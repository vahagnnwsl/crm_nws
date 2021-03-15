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
     * @return string
     */
    public function model()
    {
        return Order::class;
    }

    /**
     * @var string[]
     */
    public static $COLORS = [
        'red', 'blue', 'grey', 'green', 'black', 'orange', 'brown', 'yellow', 'purple', 'pink', 'firebrick', 'cornflowerblue', 'yellowgreen'
    ];

    /**
     * @var ProjectRepository
     */
    protected $projectRepository;

    /**
     * OrderRepository constructor.
     * @param ProjectRepository $projectRepository \
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param array $requestData
     * @return mixed
     */
    public function store(array $requestData)
    {
        return $this->create($requestData);
    }

    /**
     * @param int $id
     * @param array $stacks
     */
    public function syncStacks(int $id, array $stacks): void
    {
        $this->setStacks($id, $stacks);
    }

    /**
     * @param array $requestData
     * @return mixed
     */
    public function getAll(array $requestData)
    {
        return $this->filter($requestData);
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
     * @param int $id
     * @return array
     */
    public function destroy(int $id): array
    {
        return $this->delete($id);
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

        if ($requestData['status'] === self::STATUS_ONGOING) {
            $this->projectRepository->store($order, $creator_id);
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
     * @param null $date
     * @return mixed
     */
    public function getOrdersCountGroupMonthAndCreator($date = null)
    {
        return Order::selectRaw('DATE_FORMAT(created_at,"%m/%Y") as date, count(*) data,creator_id')
            ->when($date && count($date) == 2 && $date[0] !== 'null' && $date[1] !== 'null', function ($subQuery) use ($date) {
                $subQuery->whereBetween('created_at', $date);
            })
            ->groupBy('date', 'creator_id')
            ->orderBy('created_at')
            ->get();
    }

    /**
     * @param null $date
     * @return mixed
     */
    public function getOrdersCountGroupMonthAndStatuses($date = null)
    {

        return Order::selectRaw('status, count(*) data,creator_id')
            ->when($date && count($date) == 2 && $date[0] !== 'null' && $date[1] !== 'null', function ($subQuery) use ($date) {
                $subQuery->whereBetween('created_at', $date);
            })
            ->groupBy('status', 'creator_id')
            ->orderBy('created_at')
            ->get();
    }

}
