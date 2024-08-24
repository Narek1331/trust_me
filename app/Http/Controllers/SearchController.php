<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\{
    CheckService,
    ReviewTypeService,
    DomainInfoService,
    CommentService,
    InfoService,
    SearchService
};
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;
use GuzzleHttp\Exception\RequestException;
use App\Http\Requests\Search\StoreRequest as SearchStoreRequest;
use App\Rules\NoScriptCode;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
     * @var CommentService
     */
    protected $commentService;

    /**
     * @var InfoService
     */
    protected $infoService;

    /**
     * @var SearchService
     */
    protected $searchService;

    /**
     * SearchController constructor.
     *
     * @param CheckService $checkService
     * @param ReviewTypeService $reviewTypeService
     * @param DomainInfoService $domainInfoService
     * @param CommentService $commentService
     * @param InfoService $infoService
     * @param SearchService $searchService
     */
    public function __construct(
        CheckService $checkService,
        ReviewTypeService $reviewTypeService,
        DomainInfoService $domainInfoService,
        CommentService $commentService,
        InfoService $infoService,
        SearchService $searchService
    ) {
        $this->checkService = $checkService;
        $this->reviewTypeService = $reviewTypeService;
        $this->domainInfoService = $domainInfoService;
        $this->commentService = $commentService;
        $this->infoService = $infoService;
        $this->searchService = $searchService;
    }

    /**
     * Handles search requests and returns the appropriate view with domain information.
     *
     * @param string $checkSlug
     * @param string $q
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(string $checkSlug, string $q)
    {
        try {

            $validator = Validator::make(['q' => $q], [
                'q' => ['required', 'string', new NoScriptCode],
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Fetch check data
            $check = $this->checkService->getBySlug($checkSlug);

            if (!$check) {
                return redirect()->back()->with('error', 'Check not found.');
            }

            $domainInfo = [];
            $allDomains = [];
            $additionalInfo = [];
            $comments = [];
            $ratingTypes = [];

            // Fetch domain information if applicable
            if ($check->slug === 'site' || ($check->parentCheck && $check->parentCheck->slug === 'site')) {
                $domainInfo = $this->domainInfoService->getDomainIpInfo($q);

                if ($domainInfo && isset($domainInfo['ip'])) {
                    $allDomains = $this->domainInfoService->getAllDomainsByIp($domainInfo['ip']);
                }

                $additionalInfo = $this->infoService->findBySearch($q);
            }

            $comments = $this->commentService->getBySearchAndCheckId($q, $check->id);
            $ratingTypes = $this->reviewTypeService->getAll();



            $this->searchService->store([
                'check_id' => $check->id,
                'text' => $q
            ]);

            $searches = $this->searchService->getByText($q);

            return view('info', compact('check', 'q', 'ratingTypes', 'domainInfo', 'comments', 'additionalInfo', 'allDomains','searches'));

        } catch (InvalidArgumentException $e) {
            Log::error('Предоставлен неверный домен: ' . $e->getMessage());
            return redirect()->route('welcome')->with('error', 'Предоставлен неверный домен.');
        } catch (RequestException $e) {
            Log::error('Ошибка запроса: ' . $e->getMessage());
            return redirect()->route('welcome')->with('error', 'Не удалось получить информацию о домене.');
        } catch (ModelNotFoundException $e) {
            Log::error('Проверка не найдена: ' . $e->getMessage());
            return redirect()->route('welcome')->with('error', 'Проверка не найдена.');
        } catch (\Exception $e) {
            Log::error('Неожиданная ошибка: ' . $e->getMessage());
            return redirect()->route('welcome')->with('error', 'Произошла неожиданная ошибка.');
        }

    }

    /**
     * Get searches.
     *
     * @return \Illuminate\View\View
     */
    public function latest()
    {
        $searches = $this->searchService->get();
        return view('latest-search',compact('searches'));
    }

}
