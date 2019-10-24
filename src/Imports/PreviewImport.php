<?php

namespace Maatwebsite\LaravelNovaExcel\Imports;

use Laravel\Nova\Resource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\LaravelNovaExcel\Models\Upload;
use Maatwebsite\LaravelNovaExcel\Concerns\BelongsToAction;

class PreviewImport implements ToCollection, WithLimit, WithEvents, Responsable
{
    use BelongsToAction;

    /**
     * @var array
     */
    protected $rows = [];

    /**
     * @var array
     */
    protected $headings = [];

    /**
     * @var int
     */
    protected $totalRows = 0;

    /**
     * @var Upload
     */
    protected $upload;

    /**
     * @var NovaRequest
     */
    protected $request;

    /**
     * @param Upload      $upload
     * @param NovaRequest $request
     */
    public function __construct(Upload $upload, NovaRequest $request)
    {
        $this->upload  = $upload;
        $this->request = $request;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        if ($this->action()->usesHeadingRow()) {
            $this->headings = $collection->shift();
        } else {
            $this->headings = $collection->first()->keys();
        }

        $this->rows = $collection->all();
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $this->totalRows = head($event->getReader()->getTotalRows()) - 1;
            },
        ];
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function toResponse($request)
    {
        if (! $this->upload->stats) {
            $this->upload->stats = [
                'rows'      => $this->rows,
                'headings'  => $this->headings,
                'totalRows' => $this->totalRows,
                'fields'    => $this->resource()->creationFields($this->request),
            ];

            $this->upload->update();
        }

        return new JsonResponse($this->upload->stats);
    }

    /**
     * @return int
     */
    public function limit(): int
    {
        $previewRows = $this->action()->getPreviewRows();

        return $this->action()->usesHeadingRow() ? $previewRows + 1 : $previewRows;
    }

    /**
     * @return resource
     */
    protected function resource()
    {
        return $this->upload->getResourceInstance();
    }
}