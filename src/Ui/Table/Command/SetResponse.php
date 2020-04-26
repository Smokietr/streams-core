<?php

namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Illuminate\Routing\ResponseFactory;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class SetResponse
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetResponse
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new SetTableResponse instance.
     *
     * @param TableBuilder $builder
     */
    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param ResponseFactory $response
     */
    public function handle(ResponseFactory $response)
    {
        $table = $this->builder->getTable();

        if (request()->has('_async')) {

            $table->setResponse($response->make($table->toJson()));

            return;
        }

        $options = $table->getOptions();
        $data    = $table->getData();

        $table->setResponse(
            $response->view(
                $options->get('wrapper_view', 'streams::default'),
                $data
            )
        );
    }
}