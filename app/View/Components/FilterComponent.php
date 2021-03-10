<?php

namespace App\View\Components;

use App\Http\Repositories\AgentRepository;
use App\Http\Repositories\DeveloperRepository;
use App\Http\Repositories\StackRepository;
use App\Http\Repositories\UserRepository;
use Illuminate\View\Component;

class FilterComponent extends Component
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var AgentRepository
     */
    protected $agentRepository;

    /**
     * @var DeveloperRepository
     */
    protected $developerRepository;

    /**
     * @var StackRepository
     */
    protected $stackRepository;

    /**
     * @var array
     */
    protected $filterAttributes;

    /**
     * FilterComponent constructor.
     * @param array $filterAttributes
     */
    public function __construct(array $filterAttributes)
    {
        $this->developerRepository = new DeveloperRepository();
        $this->agentRepository = new AgentRepository();
        $this->userRepository = new UserRepository();
        $this->stackRepository = new StackRepository();
        $this->filterAttributes = $filterAttributes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {

        $filterAttrs = $this->attributes();

        return view('components.filter-component', compact('filterAttrs'));
    }

    /**
     * @return array
     */
    public function attributes(): array
    {


        $array = [];

        foreach ($this->filterAttributes as $attr) {

            switch ($attr) {


                case 'order_source':
                    $array[$attr] = [
                        'title' => 'Source',
                        'name' => 'sources[]',
                        'request_name' => 'sources',
                        'type' => 'select',
                        'options' => arrayConvertForSelect2(orderSources())
                    ];
                    break;

                case 'developer':
                    $array[$attr] = [
                        'title' => 'Developer',
                        'name' => 'developer_id[]',
                        'request_name' => 'developer_id',
                        'type' => 'select',
                        'options' => collectionConvertForSelect2($this->developerRepository->getAccepted())
                    ];
                    break;

                case 'team_lead':
                    $array[$attr] = [
                        'title' => 'Team lead',
                        'name' => 'team_lead_id[]',
                        'request_name' => 'team_lead_id',
                        'type' => 'select',
                        'options' => collectionConvertForSelect2($this->developerRepository->getAccepted())
                    ];
                    break;

                case 'order_status':
                    $array[$attr] = [
                        'title' => 'Status',
                        'name' => 'status[]',
                        'request_name' => 'status',
                        'type' => 'select',
                        'options' => arrayConvertForSelect2(orderStatuses(),true)
                    ];
                    break;

                case 'agent':
                    $array[$attr] = [
                        'title' => 'Agent',
                        'name' => 'agent_id[]',
                        'request_name' => 'agent_id',
                        'type' => 'select',
                        'options' => collectionConvertForSelect2($this->agentRepository->getAll())
                    ];
                    break;

                case 'creator':
                    $array[$attr] = [
                        'title' => 'Creator',
                        'name' => 'creator_id[]',
                        'request_name' => 'creator_id',
                        'type' => 'select',
                        'options' => collectionConvertForSelect2($this->userRepository->all())
                    ];
                    break;
                case 'created':
                    $array[$attr] = [
                        'title' => 'Created',
                        'name' => 'created_at',
                        'type' => 'date_range'
                    ];
                    break;
                case 'name':
                    $array[$attr] = [
                        'title' => 'Name',
                        'name' => 'name',
                        'type' => 'input_text'
                    ];
                    break;
                case 'stacks':
                    $array[$attr] = [
                        'title' => 'Stacks',
                        'request_name' => 'stacks',
                        'name' => 'stacks[]',
                        'type' => 'select',
                        'options' => collectionConvertForSelect2($this->stackRepository->getAll())
                    ];
                    break;
            }


        }

        return $array;
    }
}
