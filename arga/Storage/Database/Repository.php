<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 12/20/18
 * Time: 11:36 AM
 */

namespace Arga\Storage\Database;

abstract class Repository
{
    use ValidatorTrait;

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    abstract protected function model();

    abstract protected function validateData(array $data, $id = null): ?array;

    public function get($detail = false): array
    {
        $output = [];
        $data = $this->model()->get();
        /** @var \Arga\Storage\Database\Contracts\SerializableModel $item */
        foreach ($data as $item) {
            array_push($output,
                $detail ?
                    $item->toAll() :
                    $item->toOriginal()
            );
        }

        return $output;
    }

    public function paginate($detail = false): array
    {
        $output = [];
        $data = $this->model()->paginate();

        /** @var \Arga\Storage\Database\Contracts\SerializableModel $item */
        foreach ($data->items() as $k => $item) {
            $output['data'][$k] =
                $detail ?
                    $item->toAll() :
                    $item->toOriginal();
        }

        $output['meta']['pagination'] = [
            'total'        => $data->total(),
            'count'        => count($data->items()),
            'per_page'     => $data->perPage(),
            'current_page' => $data->currentPage(),
            'total_pages'  => $data->lastPage(),
            'links'        => [
                'first_page_url'    => $data->url(1),
                'last_page_url'     => $data->url($data->lastPage()),
                'next_page_url'     => $data->nextPageUrl(),
                'previous_page_url' => $data->previousPageUrl(),
            ],
            'start_index'  => ($data->currentPage() - 1) * $data->perPage() + 1,
        ];

        return $output;
    }

    public function destroy($id): bool
    {
        return $this->model()->findOrFail($id)->delete();
    }

    public function count(): int
    {
        return $this->model()->count();
    }

    public function find($id, $detail = false): array
    {
        /** @var \Arga\Storage\Database\Contracts\SerializableModel $data */
        $data = $this->model()->findOrFail($id);

        return $detail ?
            $data->toAll() :
            $data->toOriginal();
    }
}
