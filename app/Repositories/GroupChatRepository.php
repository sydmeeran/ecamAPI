<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 12/11/18
 * Time: 11:54 AM
 */

namespace App\Repositories;

use App\GroupChat;
use App\Transformers\GroupChatTransformer;
use Arga\Storage\Cloudinary\CloudinaryClient;
use Arga\Storage\Database\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use League\Fractal\TransformerAbstract;

class GroupChatRepository extends BaseRepository
{
    private $image;

    public function __construct(TransformerAbstract $abstract = null)
    {
        $this->transformer = $abstract ?? new GroupChatTransformer();
        $this->image = app(CloudinaryClient::class);
    }

    /**
     * @return Builder
     */
    protected function model(): Builder
    {
        return GroupChat::query()->with([
            'user',
            'assigned',
        ]);
    }

    /**
     * @param array $data
     * @param null $id
     * @return array|null
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateData(array $data, $id = null): ?array
    {
        $this->validate($data, [
            'sender_id'   => 'required|exists:users,id',
            'message'     => 'required|string|max:65535',
            'assigned_id' => 'nullable|exists:users,id',
        ]);

        return $data;
    }

    /**
     * @param array $attributes
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attributes)
    {
        $data = $this->validateData($attributes);
        $model = $this->model()->create($data);
        /** @var GroupChat $model */
        $this->onSaving($model, $data);

        return $this->item($model);
    }

    protected function onSaving(GroupChat $chat, array $data)
    {
        if ($image = array_get($data, 'image')) {
            if (array_get($image, 'id')) {
                $this->image->update($image['id'], $chat);
            } else {
                $this->image->update(array_column($image, 'id'), $chat);
            }
        }
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(array $attributes, $id)
    {
        $data = $this->validateData($attributes);
        $model = $this->model()->findOrFail($id);
        $model->update($data);

        return $this->item($model);
    }
}
