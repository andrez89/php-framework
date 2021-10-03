<?php

namespace App\Controllers;

use App\Core\App;

class SearchController
{

    public function results()
    {
        if (isLoggedIn()) {
            $customers = [];
            $q = "";

            // get data for the query
            if ((isset($_GET["q"]) && $_GET["q"] != "") || isMonitoringUser()) {
                $q = isset($_GET["q"]) ? $_GET["q"] : "";
                if ($q == "sms vai") {
                    //sendTestSms("+393466080284"); //sendTestSms("+393498486736"); //die();
                }
                $customers = App::get('database')->selectLIKE(
                    'v_customers c INNER JOIN addresses a on c.customer_id = a.address_customer',
                    [
                        "customer_desc" => $q,
                        "address_town" => $q
                    ],
                    [],
                    "DISTINCT c.*"
                );
            }
            return view('pages/search', [
                "q" => $q,
                "customers" => $customers,
                "total" => sizeof($customers)
            ]);
        } else {
            expiredSession();
        }
    }

    public function api()
    {
        if (isLoggedIn()) {
            $customers = App::get('database')->selectAll('customers');
            json($customers);
        } else {
            expiredSession();
        }
    }
}
