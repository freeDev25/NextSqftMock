<?php
include ABSPATH . 'vendor/autoload.php';

use Shuchkin\SimpleXLSX;
use PhpOffice\PhpSpreadsheet\IOFactory;

define("SEO_PAGE_TEMPLATE", "property-search-results-seo.php");

/**
 * Convert a string to snake_case.
 *
 * @param string $string
 * @return string
 */
function toSnakeCase($string)
{
    $string = trim($string);
    // Convert spaces (and multiple spaces) to underscore, lowercase the result
    $string = strtolower(preg_replace('/\s+/', '_', $string));
    // Optionally, remove any characters that are not alphanumeric or underscores:
    $string = preg_replace('/[^a-z0-9_]/', '', $string);
    return $string;
}


require_once 'bulk-uploader-page.php';
require_once 'utility.php';

/**
 * Proper way to enqueue scripts and styles
 */
function wpdocs_theme_name_scripts()
{
    wp_enqueue_style('batch-script', get_template_directory_uri() . '/batch-script/batch-script.css');
    wp_enqueue_script('batch-script', get_template_directory_uri() . '/batch-script/batch-script.js', array(), '1.0.0', true);
}
add_action('admin_enqueue_scripts', 'wpdocs_theme_name_scripts');

// function readExcel($file)
// {

//     if ($xlsx = SimpleXLSX::parse($file)) {
//         echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';
//         foreach ($xlsx->rows() as $r) {
//             echo '<tr><td>' . implode('</td><td>', $r) . '</td></tr>';
//         }
//         echo '</table>';
//     } else {
//         echo SimpleXLSX::parseError();
//     }
//     // if ($xls =  SimpleXLSX::parse($file)) {
//     //     echo "TEST IN";
//     //     $rows = $xls->rows();
//     //     print_r($rows);
//     //     // $arr = $xls->rows();
//     //     // array_shift($arr);
//     //     // foreach ($arr as $array_values) {
//     //     //     $page_title = $array_values[0];
//     //     //     $seo_title =  $array_values[1];
//     //     //     $seo_keywords =  $array_values[2];
//     //     //     $seo_description =  $array_values[3];
//     //     //     // $search_keywords =  $array_values[4];

//     //     //     $filters = array(
//     //     //         'search_keywords' =>  $array_values[4],
//     //     //         'location' =>  $array_values[5],
//     //     //         'price_form' =>  $array_values[6],
//     //     //         'price_to' =>  $array_values[7],
//     //     //         'category' =>  $array_values[8],
//     //     //         'type' =>  $array_values[9],
//     //     //         'area_from' =>  $array_values[10],
//     //     //         'area_to' =>  $array_values[11],
//     //     //         'amenities' =>  $array_values[12]
//     //     //     );

//     //     //     // $location =  $array_values[5];
//     //     //     // $from_price =  $array_values[6];
//     //     //     // $to_price =  $array_values[7];
//     //     //     // $category =  $array_values[8];
//     //     //     // $type =  $array_values[9];
//     //     //     // $area =  $array_values[10];
//     //     //     // $amenities =  $array_values[11];

//     //     //     // $page_id = create_page($page_title, '');
//     //     //     // $status = add_to_yoast_seo($page_id, $seo_title, $seo_description,  $seo_keywords);
//     //     //     // filter_update($page_id, $filters);
//     //     // }
//     // } else {
//     //     echo SimpleXLSX::parseError();
//     // }
// }

function readExcel($inputFileName)
{

    // $inputFileName = ABSPATH . '/wp-content/uploads/seo-excel/Seo Pages 2025.xlsx';

    try {
        // Load the XLSX file
        $spreadsheet = IOFactory::load($inputFileName);
        $worksheet = $spreadsheet->getActiveSheet();

        $data = [];
        $header = [];
        $isFirstRow = true;

        // Iterate over each row in the worksheet
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            // $cellIterator->setIterateOnlyExistingCells(true);
            $rowData = [];

            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }

            // Skip rows that are completely empty
            if (empty(array_filter($rowData, function ($value) {
                return !is_null($value) && $value !== '';
            }))) {
                continue;
            }

            if ($isFirstRow) {
                // Convert header names to snake_case
                $header = array_map('toSnakeCase', $rowData);
                // _p($header);
                $isFirstRow = false;
            } else {
                // If row has fewer cells than header, fill missing ones with null
                $rowData = array_pad($rowData, count($header), null);
                $page = array_combine($header, $rowData);



                // Push the data to the array
                array_push($data, $page);

                $page_title = $page['page_title'];
                $seo_title = $page['seo_title'];
                $seo_description = $page['seo_description'];
                $seo_keywords = $page['seo_keywords'];

                // Keys you want to extract
                $desiredKeys = ['search_keywords', 'location', 'price_form', 'price_to', 'category', 'type', 'area_from', 'area_to', 'amenities'];

                // Create a subset by intersecting the keys
                $filters = array_intersect_key($page, array_flip($desiredKeys));
                // Mapping different keys
                $filters['price_form'] = $page['from_price'];
                $filters['price_to'] = $page['to_price'];

                // _p($page);
                // _p($filters);
                // print_r($filters);

                // $filters = array(
                //     'search_keywords' =>  $array_values[4],
                //     'location' =>  $array_values[5],
                //     'price_form' =>  $array_values[6],
                //     'price_to' =>  $array_values[7],
                //     'category' =>  $array_values[8],
                //     'type' =>  $array_values[9],
                //     'area_from' =>  $array_values[10],
                //     'area_to' =>  $array_values[11],
                //     'amenities' =>  $array_values[12]
                // );

                $page_id = create_page($page_title, '');
                $status = add_to_yoast_seo($page_id, $seo_title, $seo_description,  $seo_keywords);
                filter_update($page_id, $filters);
            }
        }

        // Output the associative array
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
    } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
        echo 'Error loading file: ' . $e->getMessage();
    }
}
