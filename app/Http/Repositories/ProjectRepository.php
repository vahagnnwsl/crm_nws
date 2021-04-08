<?php

namespace App\Http\Repositories;

use App\Http\Services\ActivityServices;
use App\Models\Order;
use App\Models\Project;
use App\Models\ProjectRate;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class ProjectRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return Project::class;
    }

    /**
     * @param array $requestData
     * @return mixed
     */
    public function getAll(array $requestData)
    {

        return $this->model()::when(isset($requestData['sources']) && count($requestData['sources']), function ($q) use ($requestData) {
            return $q->whereIn('source', $requestData['sources']);
        })
            ->when(isset($requestData['status']) && count($requestData['status']), function ($q) use ($requestData) {
                return $q->whereIn('status', $requestData['status']);
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
            ->when(isset($requestData['name']), function ($q) use ($requestData) {
                return $q->where('name', 'LIKE', "%" . $requestData['name'] . "%");
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

    /**
     * @param Order $order
     * @param int $creator_id
     */
    public function store(Order $order, int $creator_id): void
    {
        $data = [
            'creator_id' => $creator_id,
            'order_id' => $order->id
        ];

        $filtered = Arr::except($order->getAttributes(), ['id', 'created_at', 'updated_at', 'hash', 'status', 'budget', 'currency']);

        $project = $this->create(array_merge($filtered, $data));

        if ($order->stacks) {
            $this->setStacks($project->id, $order->stacks->pluck('id')->toArray());
        }
    }

    /**
     * @param array $requestData
     * @param int $id
     */
    public function update(array $requestData, int $id): void
    {
        $this->edit($id, $requestData);
    }

    /**
     * @param array $requestData
     * @param int $project_id
     * @return bool
     */
    public function storePayment(array $requestData, int $project_id): bool
    {
        if (isset($requestData['attachment'])) {
            $requestData['invoice'] = $this->base64Upload($requestData['attachment'], 'payments');
        }

        $project = $this->getById($project_id);

        $rate = $project->rates()->where(['default' => 1])->first();

        if ($rate) {

            $requestData['currency'] = $rate->currency;
            $requestData['budget'] = $rate->budget;
            $project->payments()->create($requestData);

            return true;
        }

        return false;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getPayments(int $id)
    {
        return $this->getById($id)->payments()->orderByDesc('created_at')->get();
    }

    /**
     * @param int $project_id
     * @param int $payment_id
     */
    public function deletePayment(int $project_id, int $payment_id): void
    {
        $this->getById($project_id)->payments()->whereId($payment_id)->delete();
    }

    /**
     * @param $id
     * @param array $requestData
     * @param int $creator_id
     * @return bool
     */
    public function storeRate($id, array $requestData, int $creator_id): bool
    {
        $project = $this->getById($id);

        $project->rates()->update(['default' => 0]);

        $requestData['default'] = 1;

        $requestData['creator_id'] = $creator_id;

        $project->rates()->create($requestData);

        return true;
    }

}
