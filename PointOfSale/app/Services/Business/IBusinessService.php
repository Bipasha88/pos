<?php

namespace App\Services\Business;

use App\BusinessObjects\Business;
use App\Utility\TableData;

interface IBusinessService
{
    public function createBusiness($businessName, $ownerId);
    public function getBusiness($id);
    public function updateBusiness($id, Business $business);
    public function deleteBusiness($id);
    public function getAllBusinesses();
    public function getOwnedBusiness($customerId);
    public function archiveBusiness($id);
    public function unarchiveBusiness($id);
    public function searchBusiness($search_text);
    public function getBusinessByName($name);
    public function getBusinesses($offset, $limit, $search, $orderColumn, $direction): TableData;
}
