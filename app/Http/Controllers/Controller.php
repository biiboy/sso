<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        /**
         * Manager: firdauss
         * Lead Asset: marinis
         * Lead Support: THadiwidjaja
         * Coor Helpdesk: dardiansyah
         * Coor Support Jakarta: filsufh
         * Coor Support Kediri: hendrianr
         * Coor Asset Kediri: normiati
         * Coor Support SBY: febrids
         * Coor Support Gempol: yudimp
         * Support SBY: rfebriadi, arozaq, bhandoko
         * Support GMP: ssusanto01, mlukman, mrohman
         * Support KDR: ssabdiyanto, ryuwono01, liemrjw
         * Support JKT: tmargiono, tjahyadiw, gilangt
         * Helpdesk JKT: srantetampang, ahamim, chandrak
         * Asset JKT: mmutiara, ikurniasari, akusuma01
         * Asset KDR: desyzj, dhandoko
         * Asset SBY: ksoleh
         * Asset GMP: denokp
         */

        // AuthService::login('THadiwidjaja');
    }
}
