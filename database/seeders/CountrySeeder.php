<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\Country;
  
class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::truncate();

        $countries = array(
                    'Afghanistan',
                    'Aland Islands',
                    'Albania',
                    'Algeria',
                    'American Samoa',
                    'Andorra',
                    'Angola',
                    'Anguilla',
                    'Antarctica',
                    'Antigua And Barbuda',
                    'Argentina',
                    'Armenia',
                    'Aruba',
                    'Australia',
                    'Austria',
                    'Azerbaijan',
                    'Bahrain',
                    'Bangladesh',
                    'Barbados',
                    'Belarus',
                    'Belgium',
                    'Belize',
                    'Benin',
                    'Bermuda',
                    'Bhutan',
                    'Bolivia',
                    'Bonaire, Sint Eustatius and Saba',
                    'Bosnia and Herzegovina',
                    'Botswana',
                    'Bouvet Island',
                    'Brazil',
                    'British Indian Ocean Territory',
                    'Brunei',
                    'Bulgaria',
                    'Burkina Faso',
                    'Burundi',
                    'Cambodia',
                    'Cameroon',
                    'Canada',
                    'Cape Verde',
                    'Cayman Islands',
                    'Central 3n Republic',
                    'Chad',
                    'Chile',
                    'China',
                    'Christmas Island',
                    'Cocos (Keeling) Islands',
                    'Colombia',
                    'Comoros',
                    'Congo',
                    'Cook Islands',
                    'Costa Rica',
                    'Cote DIvoire (Ivory Coast)',
                    'Croatia',
                    'Cuba',
                    'Curaçao',
                    'Cyprus',
                    'Czech Republic',
                    'Democratic Republic of the Congo',
                    'Denmark',
                    'Djibouti',
                    'Dominica',
                    'Dominican Republic',
                    'East Timor',
                    'Ecuador',
                    'Egypt',
                    'El Salvador',
                    'Equatorial Guinea',
                    'Eritrea',
                    'Estonia',
                    'Ethiopia',
                    'Falkland Islands',
                    'Faroe Islands',
                    'Fiji Islands',
                    'Finland',
                    'France',
                    'French Guiana',
                    'French Polynesia',
                    'French Southern Territories',
                    'Gabon',
                    'Gambia The',
                    'Georgia',
                    'Germany',
                    'Ghana',
                    'Gibraltar',
                    'Greece',
                    'Greenland',
                    'Grenada',
                    'Guadeloupe',
                    'Guam',
                    'Guatemala',
                    'Guernsey and Alderney',
                    'Guinea',
                    'Guinea-Bissau',
                    'Guyana',
                    'Haiti',
                    'Heard Island and McDonald Islands',
                    'Honduras',
                    'Hong Kong S.A.R.',
                    'Hungary',
                    'Iceland',
                    'India',
                    'Indonesia',
                    'Iran',
                    'Iraq',
                    'Ireland',
                    'Israel',
                    'Italy',
                    'Jamaica',
                    'Japan',
                    'Jersey',
                    'Jordan',
                    'Kazakhstan',
                    'Kenya',
                    'Kiribati',
                    'Kosovo',
                    'Kuwait',
                    'Kyrgyzstan',
                    'Laos',
                    'Latvia',
                    'Lebanon',
                    'Lesotho',
                    'Liberia',
                    'Libya',
                    'Liechtenstein',
                    'Lithuania',
                    'Luxembourg',
                    'Macau S.A.R.',
                    'Macedonia',
                    'Madagascar',
                    'Malawi',
                    'Malaysia',
                    'Maldives',
                    'Mali',
                    'Malta',
                    'Man (Isle of)',
                    'Marshall Islands',
                    'Martinique',
                    'Mauritania',
                    'Mauritius',
                    'Mayotte',
                    'Mexico',
                    'Micronesia',
                    'Moldova',
                    'Monaco',
                    'Mongolia',
                    'Montenegro',
                    'Montserrat',
                    'Morocco',
                    'Mozambique',
                    'Myanmar',
                    'Namibia',
                    'Nauru',
                    'Nepal',
                    'Netherlands',
                    'New Caledonia',
                    'New Zealand',
                    'Nicaragua',
                    'Niger',
                    'Nigeria',
                    'Niue',
                    'Norfolk Island',
                    'North Korea',
                    'Northern Mariana Islands',
                    'Norway',
                    'Oman',
                    'Pakistan',
                    'Palau',
                    'Palestinian Territory Occupied',
                    'Panama',
                    'Papua new Guinea',
                    'Paraguay',
                    'Peru',
                    'Philippines',
                    'Pitcairn Island',
                    'Poland',
                    'Portugal',
                    'Puerto Rico',
                    'Qatar',
                    'Reunion',
                    'Romania',
                    'Russia',
                    'Rwanda',
                    'Saint Helena',
                    'Saint Kitts And Nevis',
                    'Saint Lucia',
                    'Saint Pierre and Miquelon',
                    'Saint Vincent And The Grenadines',
                    'Saint-Barthelemy',
                    'Saint-Martin (French part)',
                    'Samoa',
                    'San Marino',
                    'Sao Tome and Principe',
                    'Saudi Arabia',
                    'Senegal',
                    'Serbia',
                    'Seychelles',
                    'Sierra Leone',
                    'Singapore',
                    'Sint Maarten (Dutch part)',
                    'Slovakia',
                    'Slovenia',
                    'Solomon Islands',
                    'Somalia',
                    'South 3',
                    'South Georgia',
                    'South Korea',
                    'South Sudan',
                    'Spain',
                    'Sri Lanka',
                    'Sudan',
                    'Suriname',
                    'Svalbard And Jan Mayen Islands',
                    'Swaziland',
                    'Sweden',
                    'Switzerland',
                    'Syria',
                    'Taiwan',
                    'Tajikistan',
                    'Tanzania',
                    'Thailand',
                    'The Bahamas',
                    'Togo',
                    'Tokelau',
                    'Tonga',
                    'Trinidad And Tobago',
                    'Tunisia',
                    'Turkey',
                    'Turkmenistan',
                    'Turks And Caicos Islands',
                    'Tuvalu',
                    'Uganda',
                    'Ukraine',
                    'United Arab Emirates',
                    'United Kingdom',
                    'United States',
                    'United States Minor Outlying Islands',
                    'Uruguay',
                    'Uzbekistan',
                    'Vanuatu',
                    'Vatican City State (Holy See)',
                    'Venezuela',
                    'Vietnam',
                    'Virgin Islands (British)',
                    'Virgin Islands (US)',
                    'Wallis And Futuna Islands',
                    'Western Sahara',
                    'Yemen',
                    'Zambia',
                    'Zimbabwe'
        );

       
        $regions = array(
                    '1',
                    '2',
                    '2',
                    '3',
                    '4',
                    '2',
                    '3',
                    '5',
                    '6',
                    '5',
                    '5',
                    '1',
                    '5',
                    '4',
                    '2',
                    '1',
                    '1',
                    '1',
                    '5',
                    '2',
                    '2',
                    '5',
                    '3',
                    '5',
                    '1',
                    '5',
                    '5',
                    '2',
                    '3',
                    '7',
                    '5',
                    '3',
                    '1',
                    '2',
                    '3',
                    '3',
                    '1',
                    '3',
                    '5',
                    '3',
                    '5',
                    '3',
                    '3',
                    '5',
                    '1',
                    '4',
                    '4',
                    '5',
                    '3',
                    '3',
                    '4',
                    '5',
                    '3',
                    '2',
                    '5',
                    '5',
                    '2',
                    '2',
                    '3',
                    '2',
                    '3',
                    '5',
                    '5',
                    '1',
                    '5',
                    '3',
                    '5',
                    '3',
                    '3',
                    '2',
                    '3',
                    '5',
                    '2',
                    '4',
                    '2',
                    '2',
                    '5',
                    '4',
                    '3',
                    '3',
                    '3',
                    '1',
                    '2',
                    '3',
                    '2',
                    '2',
                    '5',
                    '5',
                    '5',
                    '4',
                    '5',
                    '2',
                    '3',
                    '3',
                    '5',
                    '5',
                    '7',
                    '5',
                    '1',
                    '2',
                    '2',
                    '1',
                    '1',
                    '1',
                    '1',
                    '2',
                    '1',
                    '2',
                    '5',
                    '1',
                    '2',
                    '1',
                    '1',
                    '3',
                    '4',
                    '2',
                    '1',
                    '1',
                    '1',
                    '2',
                    '1',
                    '3',
                    '3',
                    '3',
                    '2',
                    '2',
                    '2',
                    '1',
                    '2',
                    '3',
                    '3',
                    '1',
                    '1',
                    '3',
                    '2',
                    '2',
                    '4',
                    '5',
                    '3',
                    '3',
                    '3',
                    '5',
                    '4',
                    '2',
                    '2',
                    '1',
                    '2',
                    '5',
                    '3',
                    '3',
                    '1',
                    '3',
                    '4',
                    '1',
                    '2',
                    '4',
                    '4',
                    '5',
                    '3',
                    '3',
                    '4',
                    '4',
                    '1',
                    '4',
                    '2',
                    '1',
                    '1',
                    '4',
                    '1',
                    '5',
                    '4',
                    '5',
                    '5',
                    '1',
                    '4',
                    '2',
                    '2',
                    '5',
                    '1',
                    '3',
                    '2',
                    '2',
                    '3',
                    '3',
                    '5',
                    '5',
                    '5',
                    '5',
                    '5',
                    '5',
                    '4',
                    '2',
                    '3',
                    '1',
                    '3',
                    '2',
                    '3',
                    '3',
                    '1',
                    '5',
                    '2',
                    '2',
                    '4',
                    '3',
                    '3',
                    '5',
                    '1',
                    '3',
                    '2',
                    '1',
                    '3',
                    '5',
                    '2',
                    '3',
                    '2',
                    '2',
                    '1',
                    '1',
                    '1',
                    '3',
                    '1',
                    '5',
                    '3',
                    '4',
                    '4',
                    '5',
                    '3',
                    '1',
                    '1',
                    '5',
                    '4',
                    '3',
                    '2',
                    '1',
                    '2',
                    '5',
                    '5',
                    '5',
                    '1',
                    '4',
                    '2',
                    '5',
                    '1',
                    '5',
                    '5',
                    '4',
                    '3',
                    '1',
                    '3',
                    '3'
        );

  
       
        foreach ($countries as $key => $country) {
            Country::create( 
                            array("name" => $country,"region_id" => $regions[$key])
                        );
        }
    }
}