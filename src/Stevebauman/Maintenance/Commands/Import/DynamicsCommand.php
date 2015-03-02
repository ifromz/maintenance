<?php

namespace Stevebauman\Maintenance\Commands\Import;

use Stevebauman\Maintenance\Models\Category;
use Stevebauman\Maintenance\Models\Location;
use Stevebauman\Maintenance\Models\Asset;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Console\Command;

class DynamicsCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'maintenance:import-dynamics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports microsoft dynamics data into the maintenance application';

    /**
     * The available components to import
     *
     * @var array
     */
    protected $components = array(
        'assets' => 'Stevebauman\Maintenance\Models\Dynamics\FixedAsset',
    );

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $component = $this->argument('component');
        $this->verifyComponent($component);

        $model = $this->askForModel();
        $this->verifyModel($model);

        $limit = $this->askHowManyRecords();

        $query = new $model;

        $query
            ->newQuery()
            ->where('Asset Status', '!=', 'Retired');

        $records = array();

        switch($limit)
        {
            case 'None':
                break;
            case 'All':
                $records = $query->all();
                break;
            default:
                $records = $query
                    ->where('Asset Class ID', 'LIKE', 'TRUCKS%')
                    ->take($limit)
                    ->get();
                break;
        }

        $imported = 0;

        switch($component)
        {
            case 'assets':
                $imported = $this->importAssets($records);
                break;
            default:
                break;
        }

        $this->info(sprintf('Successfully imported: %s records.', $imported));

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('component', InputArgument::REQUIRED, 'The name of the component to import (ex. assets)'),
        );
    }

    /**
     * Imports the specified records into the database
     *
     * @param $records
     * @return int
     */
    private function importAssets($records)
    {
        $assets = array();

        foreach($records as $record)
        {
            $location = Location::firstOrCreate(array(
                'name' => $record->location->{'STATEDESCR'},
            ));

            $category = Category::firstOrCreate(array(
                'name' => $record->{'Asset Class ID'},
                'belongs_to' => 'assets'
            ));

            $insert = array(
                'location_id' => $location->id,
                'category_id' => $category->id,
                'import_id' => $record->{'Asset ID'},
                'name' => $record->{'Asset Description'},
                'description' => $record->{'Extended Description'},
                'acquired_at' => date("Y-m-d H:i:s", strtotime($record->{'Acquisition Date'})),
                'price' => $record->{'Acquisition Cost (General)'},
                'serial' => $record->{'Serial Number'},
                'vendor' => $record->{'Manufacturer Name'},
                'model' => $record->{'Model Number'},
            );

            $assets[] = Asset::firstOrCreate($insert);
        }

        return count($assets);
    }

    /**
     * Asks for the model to use for the import
     *
     * @return string
     */
    private function askForModel()
    {
        return $this->ask('What is the model you would like to use to import on the selected component? ', $this->components['assets']);
    }

    /**
     * Asks for the amount of records to import
     *
     * @return string
     */
    private function askHowManyRecords()
    {
        return $this->ask('How many records would you like to import? ');
    }

    /**
     * @param $model
     * @return bool
     */
    private function verifyModel($model)
    {
        if(class_exists($model)) return true;

        $this->error(sprintf('Model: %s does not exist', $model));

        exit;
    }

    private function verifyComponent($component)
    {
        if(array_key_exists($component, $this->components)) return true;

        $this->error(sprintf('Component: %s does not exist.', $component));

        exit;
    }

}