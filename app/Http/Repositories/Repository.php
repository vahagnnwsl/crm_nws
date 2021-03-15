<?php


namespace App\Http\Repositories;

use Illuminate\Support\Facades\Storage;

abstract class Repository
{

    /**
     * @return mixed
     */
    abstract function model();


    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return $this->model()::whereId($id)->first();
    }


    /**
     * @param int $id
     * @return array|string[]
     */
    public function delete(int $id): array
    {
        $model = $this->getById($id);


        if ($model) {
            foreach ($model->relationships as $relationship) {

                if ($model->$relationship && $model->$relationship->count()) {

                    return ['msg' => 'Please before delete,delete ' . $relationship . ' where ID in array [' . implode(',', $model->$relationship->pluck('id')->toArray()) . ']'];
                }
            }
        }

        $model->delete();

        return [];
    }


    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model()::create($data);
    }

    /**
     * @param int $id
     * @param array $data
     */
    public function edit(int $id, array $data)
    {
        $model = $this->getById($id);
        if ($model) {
            $model->update($data);
        }
    }

    /**
     * @param int $id
     * @param array $stacks
     */
    public function setStacks(int $id, array $stacks)
    {
        $model = $this->getById($id);
        if ($model) {
            $model->stacks()->sync($stacks);
        }
    }

    /**
     * @param string $base64
     * @param string $path
     * @return string
     */
    public function base64Upload(string $base64, string $path): string
    {
        $mimeType = explode("/", mime_content_type($base64))[1];
        $imageFileName = time() . '-' . rand(1, 999999999) . '.' . $mimeType;
        $s3 = Storage::disk();
        $filePath = '/public/' . $path . '/' . $imageFileName;
        $s3->put($filePath, file_get_contents($base64), 'public');

        return $path . '/' . $imageFileName;
    }

    /**
     * @param object $file
     * @param string $path
     * @return string
     */
    public function upload(object $file, string $path): string
    {
        $path = $file->store('/public/' . $path);

        return explode('public/', $path)[1];
    }


    /**
     * @param array $requestData
     * @return mixed
     */
    public function filter(array $requestData)
    {

        return $this->model()::when(isset($requestData['status']) && count($requestData['status']), function ($q) use ($requestData) {
            return $q->whereIn('status', $requestData['status']);
        })
            ->when(isset($requestData['positions']) && count($requestData['positions']), function ($q) use ($requestData) {
                return $q->whereIn('position', $requestData['positions']);
            })
            ->when(isset($requestData['name']), function ($q) use ($requestData) {
                if ($q->getModel()->getTable() === 'developers') {
                    return $q
                        ->where('first_name', 'LIKE', "%" . $requestData['name'] . "%")
                        ->orWhere('last_name', 'LIKE', "%" . $requestData['name'] . "%");
                }

                return $q->where('name', 'LIKE', "%" . $requestData['name'] . "%");
            })
            ->when(isset($requestData['developer_id']) && count($requestData['developer_id']), function ($q) use ($requestData) {
                return $q->where('developer_id', $requestData['developer_id']);
            })
            ->when(isset($requestData['agent_id']) && count($requestData['agent_id']), function ($q) use ($requestData) {
                return $q->where('agent_id', $requestData['agent_id']);
            })
            ->when(isset($requestData['creator_id']) && count($requestData['creator_id']), function ($q) use ($requestData) {
                return $q->where('creator_id', $requestData['creator_id']);
            })
            ->when(isset($requestData['sources']) && count($requestData['sources']), function ($q) use ($requestData) {
                return $q->whereIn('source', $requestData['sources']);
            })
            ->when(isset($requestData['created_at']), function ($q) use ($requestData) {
                $date = explode(' - ', $requestData['created_at']);

                if (count($date) === 2) {
                    return $q->whereBetween('created_at', $date);
                }

                return $q;
            })
            ->when(isset($requestData['stacks']) && count($requestData['stacks']), function ($q) use ($requestData) {
                return $q->whereHas('stacks', function ($subQuery) use ($requestData) {
                    return $subQuery->whereIn('stacks.id', $requestData['stacks']);
                });
            })
            ->orderbyDesc('created_at')->paginate(15);
    }

}
