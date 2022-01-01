<?php
/** @noinspection DuplicatedCode */

namespace App\Console\Commands;

use App\Models\Staff;
use DOMDocument;
use DOMXPath;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Console\Command;
use Symfony\Component\CssSelector\CssSelectorConverter;

use function PHPUnit\Framework\isEmpty;

class ScrapeStaffCommandAuthed extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'scrape:staff-authed {age} {status} {speciality}';

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
		$search_age = $this->argument('age');
		$search_status = $this->argument('status');
		$search_speciality = $this->argument('speciality');
		$client = new Client(['verify' => false]);
		$cookieJar = new CookieJar();
		$converter = new CssSelectorConverter();

		$getLogin = $client->get('https://www.virtualmanager.com/login/');

		$htmlString = (string)$getLogin->getBody();

		libxml_use_internal_errors(true);
		$document = new DOMDocument();
		$document->loadHTML($htmlString);

		$xpath = new DOMXPath($document);

		$token = $xpath->evaluate('//input[@type="hidden" and @name="authenticity_token"]/@value');
		$auth_token = '';
		foreach ($token as $t) {
			$auth_token = $t->nodeValue;
		}

		$client->post('https://www.virtualmanager.com/login', [
			'form_params' => [
				'email' => 'liam_aird@hotmail.com',
				'password' => '388b637e',
				'authenticity_token' => $auth_token,
				'utf8' => '✓',
			],
			'cookies' => $cookieJar
		]);

		// We have logged in here.


		for ($i = 1; $i < 9999; $i++) {
			$this->info('running page: ' . $i . ' age: ' . $search_age);

//			$employees = $client->get(
//				'https://www.virtualmanager.com/employees/search?age_max='.$search_age.'&age_min='.$search_age.'&commit=S%C3%B8g&country_id=&job_status='.$search_status.'&page=' . $i . '&search=1&speciality='.$search_speciality.'&utf8=%E2%9C%93',
//				['cookies' => $cookieJar]
//			);
			$employees = $client->get(
				'https://www.virtualmanager.com/employees/search?age_max=67&age_min=33&commit=S%C3%B8g&country_id=&job_status=2&page=' . $i . '&search=1&speciality=scout&utf8=%E2%9C%93',
				['cookies' => $cookieJar]
			);

			$empHtmlString = (string)$employees->getBody();
			$docEmp = new DOMDocument();
			$docEmp->loadHTML($empHtmlString);
			$xpathEmp = new DOMXPath($docEmp);

			if ($xpathEmp->evaluate(".//*[contains(concat(' ',normalize-space(@class),' '),' employees_search ')]//div//p")->length > 0) {
				break;
			}

			for ($j = 2; $j <= 21; $j++) {
				$nameHtml = $xpathEmp->evaluate(
					".//*[contains(concat(' ',normalize-space(@class),' '),' employees_search ')]//*[contains(concat(' ',normalize-space(@class),' '),' box ')][1]//table//tr[" . $j . "]//td[2]"
				);
				$name = $nameHtml[0]->nodeValue;
				$nameUrl = '';
				foreach ($nameHtml[0]->childNodes as $childNode) {
					$nameUrl = $childNode->attributes[0]->nodeValue;
					$nameUrl = explode('/', $nameUrl)[2];
				}

				$clubHtml = $xpathEmp->evaluate(
					".//*[contains(concat(' ',normalize-space(@class),' '),' employees_search ')]//*[contains(concat(' ',normalize-space(@class),' '),' box ')][1]//table//tr[" . $j . "]//td[3]"
				);
				$club = $clubHtml[0]->nodeValue;
				$clubUrl = null;
				if ($clubHtml[0]->nodeValue !== '-') {
					foreach ($clubHtml[0]->childNodes as $childNode) {
						$clubUrl = $childNode->attributes[0]->nodeValue;
						$clubUrl = explode('/', $clubUrl)[2];
					}
				}

				$ageHtml = $xpathEmp->evaluate(
					".//*[contains(concat(' ',normalize-space(@class),' '),' employees_search ')]//*[contains(concat(' ',normalize-space(@class),' '),' box ')][1]//table//tr[" . $j . "]//td[4]"
				);
				$age = $ageHtml[0]->nodeValue;

				$specialityHtml = $xpathEmp->evaluate(
					".//*[contains(concat(' ',normalize-space(@class),' '),' employees_search ')]//*[contains(concat(' ',normalize-space(@class),' '),' box ')][1]//table//tr[" . $j . "]//td[5]"
				);
				$speciality = $specialityHtml[0]->nodeValue;

				$statusHtml = $xpathEmp->evaluate(
					".//*[contains(concat(' ',normalize-space(@class),' '),' employees_search ')]//*[contains(concat(' ',normalize-space(@class),' '),' box ')][1]//table//tr[" . $j . "]//td[6]"
				);
				$status = $statusHtml[0]->nodeValue;

				$priceHtml = $xpathEmp->evaluate(
					".//*[contains(concat(' ',normalize-space(@class),' '),' employees_search ')]//*[contains(concat(' ',normalize-space(@class),' '),' box ')][1]//table//tr[" . $j . "]//td[7]"
				);
				$price = $priceHtml[0]->nodeValue;

				$statsHtml = $xpathEmp->evaluate(
					".//*[contains(concat(' ',normalize-space(@class),' '),' employees_search ')]//*[contains(concat(' ',normalize-space(@class),' '),' box ')][1]//table//tr[" . $j . "]//td[8]//*[contains(concat(' ',normalize-space(@class),' '),' relative ')]//img"
				);
				$stats = '';
				foreach ($statsHtml as $t2) {
					foreach ($t2->attributes as $at) {
						if ($at->name === 'onmouseover') {
							$stats = $at->textContent;
							$stats = explode(',', $stats);
							unset($stats[0]);
						}
					}
				}

				$staff = [
					'staff_id' => $nameUrl,
					'name' => $name,
					'age' => $age,
					'club' => $club,
					'club_id' => $clubUrl,
					'job' => $status,
					'speciality' => $speciality,
					'price' => $price,

					'youth' => $stats[1],
					'keeper' => $stats[2],

					'mark' => $stats[3],
					'discipline' => $stats[4],

					'potential' => $stats[5],
					'management' => $stats[6],

					'ability' => $stats[7],
					'motivation' => (int)$stats[8],
				];

				if ($speciality === 'Træner' && $stats[1] >= 19 && ($stats[2] >= 19 || $stats[3] >= 19)) {
					try {
						Staff::create($staff);
					} catch (Exception) {
						$this->info('Staff already exists: ' . $nameUrl);
					}
				}

				if ($speciality === 'Talentspejder' && $stats[5] >= 20 && ($stats[4] >= 19 || (int)$stats[8] >= 19)) {
					try {
						Staff::create($staff);
					} catch (Exception) {
						$this->info('Staff already exists: ' . $nameUrl);
					}
				}


			}
		}
	}
}