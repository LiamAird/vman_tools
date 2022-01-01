<?php

namespace App\Console\Commands;

use App\Models\Config;
use App\Models\Staff;
use Goutte\Client;
use Illuminate\Console\Command;
use Symfony\Component\CssSelector\CssSelectorConverter;

class ScrapeStaffCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'scrape:staff';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Staff Scraper';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *

	 */
	public function handle()
	{
		$client = new Client();
		$converter = new CssSelectorConverter();

//		$config = Config::first();
//		$iterate = 1000;
//
//
//		$bar = $this->output->createProgressBar($iterate);
//		$bar->start();

		$last_id = 0;

		$this->info('');
//		$this->info('start id: ' . $config->staff_id_last_end);
		$this->info('start id: ' . 11609992);
		$this->info('');

//		for ($i = $config->staff_id_last_end; $i < $config->staff_id_last_end + $iterate; $i++) {
		for ($i = 11609992; $i > 2; $i--) {
			$this->info('');
			$this->info('ID currently running: ' . $i);
			$this->info('');
			$crawler = $client->request('GET', 'https://www.virtualmanager.com/employees/' . $i);

			if ($crawler->evaluate('//title')->text() !== 'The page you were looking for doesn\'t exist (404)') {
				$staff = [
					'staff_id' => $i,

					'name' => $crawler->evaluate('//div[@class="name"]//strong')->text(),
					'age' => $crawler->evaluate('//div[@class="age"]//strong')->text(),

					'club' => $crawler->evaluate('//div[@class="club"]//strong')->text(),
					'job' => $crawler->evaluate('//div[@class="job"]//strong')->text(),
					'speciality' => $crawler->evaluate('//div[@class="speciality"]//strong')->text(),

					'youth' => $crawler->evaluate(
						$converter->toXPath('.stats table tr:first-of-type td:first-of-type .content .value')
					)->text(),
					'keeper' => $crawler->evaluate(
						$converter->toXPath('.stats table tr:first-of-type td:last-of-type .content .value')
					)->text(),

					'mark' => $crawler->evaluate(
						$converter->toXPath('.stats table tr:nth-of-type(2) td:first-of-type .content .value')
					)->text(),
					'discipline' => $crawler->evaluate(
						$converter->toXPath('.stats table tr:nth-of-type(2) td:last-of-type .content .value')
					)->text(),

					'potential' => $crawler->evaluate(
						$converter->toXPath('.stats table tr:nth-of-type(3) td:first-of-type .content .value')
					)->text(),
					'management' => $crawler->evaluate(
						$converter->toXPath('.stats table tr:nth-of-type(3) td:last-of-type .content .value')
					)->text(),

					'ability' => $crawler->evaluate(
						$converter->toXPath('.stats table tr:nth-of-type(4) td:first-of-type .content .value')
					)->text(),
					'motivation' => $crawler->evaluate(
						$converter->toXPath('.stats table tr:nth-of-type(4) td:last-of-type .content .value')
					)->text(),
				];

				Staff::create($staff);

//				if ($staff['speciality'] === 'Trainer') {
//					if (($staff['youth'] >= 19 && $staff['keeper'] >= 19) || ($staff['youth'] >= 19 && $staff['mark'] >= 19)) {
//						// calculate potential
//						$staff['employee_potential'] = ($staff['youth'] + $staff['keeper'] + $staff['mark']) / 3;
//
//					}
//				}
//
//				if ($staff['speciality'] === 'Scout') {
//					if ($staff['potential'] >= 19 && ($staff['discipline'] >= 17 || $staff['motivation'] >= 17)) {
//						$staff['employee_potential'] = ($staff['potential'] + $staff['discipline'] + $staff['motivation']) / 3;
//						Staff::create($staff);
//					}
//				}
			}
//			$bar->advance();

			$last_id = $i;
		}

//		$config->update(
//			[
//				'staff_id_start' => $config->staff_id_last_end,
//				'staff_id_last_end' => $last_id,
//			]
//		);
//
//		$bar->finish();
	}
}
