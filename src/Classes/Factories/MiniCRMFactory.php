<?php 

use MiniCRM\Models\MiniCRM;
use MiniCRM\Models\CompanyType;

namespace MiniCRM\Factories;

class MiniCRMFactory {
    private $container;

    /**
     * Builds the companies classes.
     * @return MiniCRM
     */
    function get(){
        $companies = MiniCRMCompanyClassFactory::get_all();

        return new \MiniCRM\Models\MiniCRM(
            $companies,
            \MiniCRM\Models\CompanyType::get()
        );
    }

    function __invoke($container) {
        $this->container = $container;
        return $this;
    }
}