<?php

namespace MiniCRM\Factories;

use MiniCRM\Models\CompanyContact;
use MiniCRM\Models\ClientCompany;
use MiniCRM\Models\CompanyType;
use MiniCRM\Models\MiniCRMCompDetails;

class MiniCRMCompDetailsFactory {
    private $container;

    /**
     * Builds the details of a company given its id.
     * @param int $id the company id
     * @return MiniCRMCompDetails
     */
    function get_company_details($id){
        $contacts = CompanyContact::get_from_company($id);
        $types = CompanyType::get();
        
        return new MiniCRMCompDetails(
            MiniCRMCompanyClassFactory::get($id), 
            $types, 
            $contacts
        );
    }

    /**
     * Builds the details of a company's contact given its id.
     * @param int $id the company's contact id
     * @return MiniCRMCompDetails
     */
    function get_contact_details($contactid){
        $types = CompanyType::get();
        $contacts = array(CompanyContact::get($contactid));

        return new \MiniCRM\Models\MiniCRMCompDetails(new ClientCompany(0, 0, ""), $types, $contacts);
    }

    function __invoke($container) {
        $this->container = $container;

        return $this;
    }
}