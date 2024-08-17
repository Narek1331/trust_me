<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\{
    CheckService,
    ReviewTypeService,
    DomainInfoService,
    CommentService,
    InfoService
};
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;
use GuzzleHttp\Exception\RequestException;

/**
 * Class SearchController
 *
 * Controller for handling search requests and displaying domain information.
 */
class SearchController extends Controller
{
    /**
     * @var CheckService
     */
    protected $checkService;

    /**
     * @var ReviewTypeService
     */
    protected $reviewTypeService;

    /**
     * @var DomainInfoService
     */
    protected $domainInfoService;

    /**
     * SearchController constructor.
     *
     * @param CheckService $checkService
     * @param ReviewTypeService $reviewTypeService
     * @param DomainInfoService $domainInfoService
     */
    public function __construct(
        CheckService $checkService,
        ReviewTypeService $reviewTypeService,
        DomainInfoService $domainInfoService,
        CommentService $commentService,
        InfoService $infoService
    ) {
        $this->checkService = $checkService;
        $this->reviewTypeService = $reviewTypeService;
        $this->domainInfoService = $domainInfoService;
        $this->commentService = $commentService;
        $this->infoService = $infoService;

    }

    /**
     * Handles search requests and returns the appropriate view with domain information.
     *
     * @param string $checkSlug
     * @param string $q
     */
    public function index($checkSlug, $q)
    {
        try {
            $domainInfo = [];
            $additionalInfo = [];

            // Fetch check data
            $check = $this->checkService->getBySlug($checkSlug);

            if(!$check)
            {
                return redirect()->back();
            }

            if(($check->slug == 'site' || $check->parentCheck && $check->parentCheck->slug == 'site'))
            {
                // Fetch domain information
                $domainInfo = $this->domainInfoService->getDomainIpInfo($q);
                $additionalInfo = $this->infoService->findBySearch($q);
            }

            $comments = $this->commentService->getBySearchAndCheckId($q,$check->id);

            // Fetch rating types
            $ratingTypes = $this->reviewTypeService->getAll();

            return view('info', compact('check', 'q', 'ratingTypes','domainInfo','comments','additionalInfo'));
        } catch (InvalidArgumentException $e) {
            Log::error('Invalid domain provided: ' . $e->getMessage());
            return redirect()->route('welcome')->with('error', 'Invalid domain provided.');
        } catch (RequestException $e) {
            return redirect()->route('welcome')->with('error', 'Failed to fetch domain info.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('welcome')->with('error', 'Check not found.');
        } catch (\Exception $e) {
            return redirect()->route('welcome')->with('error', 'An unexpected error occurred.');
        }
    }
}
