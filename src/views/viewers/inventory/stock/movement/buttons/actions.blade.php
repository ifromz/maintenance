@extends('maintenance::layouts.buttons.dropdown')

@section('dropdown.body.content')
    <li>
        <a href="
        {{
            route('maintenance.inventory.stocks.movements.show', array(
                $item->id,
                $stock->id,
                $movement->id
            ))
        }}
        ">
            <i class="fa fa-search"></i> View Movement
        </a>
    </li>
    <li>
        <a
                href="
                {{
                    route('maintenance.inventory.stocks.movements.rollback', array(
                        $item->id,
                        $stock->id,
                        $movement->id
                    ))
                }}
                "
                data-method="post"
                data-message="Are you sure you want to roll back this movement?">
            <i class="fa fa-refresh"></i> Rollback Movement
        </a>
    </li>
@overwrite