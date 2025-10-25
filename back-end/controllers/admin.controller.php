<?php
require_once("../config/connect.php");
require_once("../models/Admin.php");
require_once("../config/session.php");
require_once("../config/csrf_verification.php");
require_once("../helpers/Pagination.php");

$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);
switch ($data["op"]) {
    case "get_users_list":

        $data_array = [
            // this are only two pagination values we define at the start
            "page" => $data["page"] ?? 0,
            "limit" => Pagination::getPageLimit($data["limit"] ?? null),
        ];
        
        try {
            $db->autocommit(false);
            
            if(!isset($_SESSION["id"])){ throw new Exception("No session", 1);}
            if($_SESSION["additional_data"]["permissions"] !== 7){ throw new Exception("No permissions", 1);}

            $pagination_values = Pagination::PaginationValues($data_array["page"], $data_array["limit"]);
            $data_array["limit"] = $pagination_values["limit"];
            $data_array["offset"] = $pagination_values["offset"];
            $total_rows = Admin::getUsersRowsCount();
            
            $users = Admin::getUsers($data_array);

            $db->commit();
            $response = [
                "success" => true, 
                "data" => $users,
                "pagination" => [
                    "total_rows" => $total_rows,
                    "limit" => $data_array["limit"],
                    "offset" => $data_array["offset"],
                ]
            ];
        } catch (Exception $e) {
            $db->rollback();
            $response = ["success" => false, "message" => $e->getMessage()];
        }

        echo json_encode($response);
        break;
    case "get_access_list":

        $data_array = [
            // this are only two pagination values we define at the start
            "page" => $data["page"] ?? 0,
            "limit" => Pagination::getPageLimit($data["limit"] ?? null),
        ];

        try {
            $db->autocommit(false);
            
            if(!isset($_SESSION["id"])){ throw new Exception("No session", 1);}
            if($_SESSION["additional_data"]["permissions"] !== 7){ throw new Exception("No permissions", 1);}

            $pagination_values = Pagination::PaginationValues($data_array["page"], $data_array["limit"]);
            $data_array["limit"] = $pagination_values["limit"];
            $data_array["offset"] = $pagination_values["offset"];
            $total_rows = Admin::getAccessRowsCount();

            $access = Admin::getAccess($data_array);

            $db->commit();
            $response = [
                "success" => true, 
                "data" => $access,
                "pagination" => [
                    "total_rows" => $total_rows,
                    "limit" => $data_array["limit"],
                    "offset" => $data_array["offset"],
                ]
            ];
        } catch (Exception $e) {
            $db->rollback();
            $response = ["success" => false, "message" => $e->getMessage()];
        }

        echo json_encode($response);
        break;
    case "get_suggestions_list":
    
        $data_array = [
            // this are only two pagination values we define at the start
            "page" => $data["page"] ?? 0,
            "limit" => Pagination::getPageLimit($data["limit"] ?? null),
        ];

        try {
            $db->autocommit(false);
            
            if(!isset($_SESSION["id"])){ throw new Exception("No session", 1);}
            if($_SESSION["additional_data"]["permissions"] !== 7){ throw new Exception("No permissions", 1);}

            $pagination_values = Pagination::PaginationValues($data_array["page"], $data_array["limit"]);
            $data_array["limit"] = $pagination_values["limit"];
            $data_array["offset"] = $pagination_values["offset"];
            $total_rows = Admin::getSuggestionsRowsCount();

            $suggestions = Admin::getSuggestions($data_array);

            $db->commit();
            $response = [
                "success" => true, 
                "data" => $suggestions,
                "pagination" => [
                    "total_rows" => $total_rows,
                    "limit" => $data_array["limit"],
                    "offset" => $data_array["offset"],
                ]
            ];
        } catch (Exception $e) {
            $db->rollback();
            $response = ["success" => false, "message" => $e->getMessage()];
        }

        echo json_encode($response);
        break;
    case "get_paid_users_list":
        
        $data_array = [
            "page" => $data["page"] ?? 0,
            "limit" => Pagination::getPageLimit($data["limit"] ?? null),
        ];

        try {
            $db->autocommit(false);
            
            if(!isset($_SESSION["id"])){ throw new Exception("No session", 1);}
            if($_SESSION["additional_data"]["permissions"] !== 7){ throw new Exception("No permissions", 1);}

            $pagination_values = Pagination::PaginationValues($data_array["page"], $data_array["limit"]);
            $data_array["limit"] = $pagination_values["limit"];
            $data_array["offset"] = $pagination_values["offset"];
            $total_rows = Admin::getPaidUsersRowsCount();

            $paid_users = Admin::getPaidUsers($data_array);

            $db->commit();
            $response = [
                "success" => true, 
                "data" => $paid_users,
                "pagination" => [
                    "total_rows" => $total_rows,
                    "limit" => $data_array["limit"],
                    "offset" => $data_array["offset"],
                ]
            ];
        } catch (Exception $e) {
            $db->rollback();
            $response = ["success" => false, "message" => $e->getMessage()];
        }
        
        echo json_encode($response);
        break;

    case "get_paid_user_data":
        
        $data_array = [
            "user_id" => $data["user_id"] ?? null,
        ];

        try {
            $db->autocommit(false);
            
            if(!isset($_SESSION["id"])){ throw new Exception("No session", 1);}
            if($_SESSION["additional_data"]["permissions"] !== 7){ throw new Exception("No permissions", 1);}

            $paid_user = Admin::getPaidUserData($data_array["user_id"]);

            $db->commit();
            $response = [
                "success" => true, 
                "data" => $paid_user,
            ];
        } catch (Exception $e) {
            $db->rollback();
            $response = ["success" => false, "message" => $e->getMessage()];
        }

        echo json_encode($response);
        break;
    case "get_therapists_list":
        
        $data_array = [
            "page" => $data["page"] ?? 0,
            "limit" => Pagination::getPageLimit($data["limit"] ?? null),
        ];

        try {
            $db->autocommit(false);
            
            if(!isset($_SESSION["id"])){ throw new Exception("No session", 1);}
            if($_SESSION["additional_data"]["permissions"] !== 7){ throw new Exception("No permissions", 1);}

            $pagination_values = Pagination::PaginationValues($data_array["page"], $data_array["limit"]);
            $data_array["limit"] = $pagination_values["limit"];
            $data_array["offset"] = $pagination_values["offset"];
            $total_rows = Admin::getTherapistsRowsCount();

            $therapists = Admin::getTherapists($data_array);

            $db->commit();
            $response = [
                "success" => true, 
                "data" => $therapists,
                "pagination" => [
                    "total_rows" => $total_rows,
                    "limit" => $data_array["limit"],
                    "offset" => $data_array["offset"],
                ]
            ];
        } catch (Exception $e) {
            $db->rollback();
            $response = ["success" => false, "message" => $e->getMessage()];
        }

        echo json_encode($response);
        break;
    default:
        $response = [
            "success" => false,
            "message" => "Invalid Operation",
        ];
        echo json_encode($response);
        break;
}