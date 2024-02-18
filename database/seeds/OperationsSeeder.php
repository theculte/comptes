<?php

use Illuminate\Support\Facades\DB;
use JeroenZwart\CsvSeeder\CsvSeeder;
use App\Http\Resources\OperationResource;

class OperationsSeeder extends CsvSeeder
{

    public function __construct()
    {
//        $this->file = '/public/upload/file/7D5oK9xRQm.csv';
	$this->tablename = 'operations';
//	$this->mapping = ['date', 'detail', 'amount', 'currency'];
	$this->mapping = ['date', 'title', 'detail', 'amount', 'currency'];
	$this->validate = ['date' => 'date_format:d/m/Y'];
	$this->truncate = false;
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	// Recommended when importing larger CSVs
//	DB::disableQueryLog();
	parent::run();

	OperationResource::parseNewOperations();
	OperationResource::parseIncommings();
    }

}
