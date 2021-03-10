<?php

namespace App\Http\Repositories;

use App\Models\Order;
use App\Models\OrderStatusComment;
use Illuminate\Support\Facades\DB;

class OrderRepository extends Repository
{

    const STATUS_SANDED = 0;
    const STATUS_PENDING = 1;
    const STATUS_INTERVIEW = 2;
    const STATUS_COMPLETE_FORM = 3;
    const STATUS_CODE_EXAMPLE = 4;
    const STATUS_TEST_TASK = 5;
    const STATUS_CONVERSATION = 6;
    const STATUS_NOT_REMOTE = 7;
    const STATUS_DECLINE = 8;
    const STATUS_FIRST_CALL = 9;
    const STATUS_SECOND_CALL = 10;
    const STATUS_OFFER = 11;
    const STATUS_ONGOING = 12;


    /**
     * @param array $requestData
     * @return mixed
     */
    public function getAll(array $requestData)
    {

        return Order::when(isset($requestData['sources']) && count($requestData['sources']), function ($q) use ($requestData) {
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
     * @param array $requestData
     * @return mixed
     */
    public function store(array $requestData)
    {
        return Order::create($requestData);
    }

    /**
     * @param int $id
     * @param array $stacks
     */
    public function syncStacks(int $id, array $stacks): void
    {
        $order = $this->getById($id);
        if ($order) {
            $order->stacks()->sync($stacks);
        }
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return Order::whereId($id)->first();
    }

    /**
     * @param array $requestData
     * @param int $id
     */
    public function update(array $requestData, int $id): void
    {
        $order = $this->getById($id);

        if ($order) {
            $order->update($requestData);
        }

    }

    /**
     * @param int $id
     */
    public function destroy(int $id): void
    {

        $order = $this->getById($id);

        $order->people()->delete();

        $order->delete();
    }

    /**
     * @param array $requestData
     * @param int $id
     * @param int $creator_id
     */
    public function updateStatus(array $requestData, int $id, int $creator_id): void
    {
        $order = $this->getById($id);

        if ($order) {
            $order->update(['status' => $requestData['status']]);
        }

        $data = [
            'comment' => $requestData['comment'],
            'creator_id' => $creator_id,
            'order_id' => $id,
            'status' => orderStatuses()[$order->status]
        ];

        if (isset($requestData['attachment'])) {
            $data['attachment'] = $this->base64Upload($requestData['attachment'], 'comments');
        }

        OrderStatusComment::create($data);

    }


    /**
     * @param int $id
     * @return array
     */
    public function getStatusComments(int $id)
    {
        $order = $this->getById($id);

        if ($order) {

            return $order->statusComments()->orderByDesc('created_at')->get();
        }

        return [];
    }

    /**
     * @return mixed
     */
    public function getOrdersCountGroupMonthAndCreator()
    {
        return Order::selectRaw('DATE_FORMAT(created_at,"%m/%Y") as date, count(*) data,creator_id')
            ->groupBy('date', 'creator_id')
            ->orderBy('created_at')
            ->get();
    }

}
