<?php

namespace App\View\Components;

use App\Http\Repositories\AgentRepository;
use App\Http\Repositories\DeveloperRepository;
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
                        'name' => 'source[]',
                        'type' => 'select',
                        'options' => orderSources()
                    ];
                    break;

                case 'developer':
                    $array[$attr] = [
                        'title' => 'Developer',
                        'name' => 'developer_id[]',
                        'type' => 'select',
                        'options' => collectionToArrayForFilter($this->developerRepository->getAccepted())
                    ];
                    break;

                case 'team_lead':
                    $array[$attr] = [
                        'title' => 'Team lead',
                        'name' => 'team_lead_id[]',
                        'type' => 'select',
                        'options' => collectionToArrayForFilter($this->developerRepository->getAccepted())
                    ];
                    break;

                case 'order_status':
                    $array[$attr] = [
                        'title' => 'Status',
                        'name' => 'status[]',
                        'type' => 'select',
                        'options' => orderStatuses()
                    ];
                    break;

                case 'agent':
                    $array[$attr] = [
                        'title' => 'Agent',
                        'name' => 'agent_id[]',
                        'type' => 'select',
                        'options' => collectionToArrayForFilter($this->agentRepository->getAll())
                    ];
                    break;

                case 'creator':
                    $array[$attr] = [
                        'title' => 'Creator',
                        'name' => 'creator_id[]',
                        'type' => 'select',
                        'options' => collectionToArrayForFilter($this->userRepository->all())
                    ];
                    break;
            }


        }

        return $array;
    }
}
