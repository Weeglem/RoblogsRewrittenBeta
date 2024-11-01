<?php

    class ForumGroup_Data{
        static function Get($ID = false)
        {
            $Groups = array();

            if($ID != false)
            {
                $Database = new Database();
                $Get = $Database->Prepare_Data_BindValue("
                SELECT *
                FROM `forums_groups`
                WHERE `GroupID` = :GroupID
                ",array(
                    ["GroupID",$ID]
                ));

                for($i = 0; $i < count($Get); $i++)
            {
                $x = $Get[$i]["GroupName"];
                $z = $Get[$i]["GroupID"];
                $Groups[$z] = array(
                    "Name" => $x,
                    "ID" => $z,
                );
            }

            foreach($Get as $Row)
            {
                $GroupID = $Row["GroupID"];

                $Get_Threads = $Database->Prepare_Data_BindValue("
                    SELECT *,
                        (
                        SELECT COUNT(*) 
                        from `forums_posts`
                        where `CategoryID` = `ForumID`
                        and `Deleted` = 0
                        AND `ParentID` IS NULL
                        ) AS `Posts`,

                        (
                        SELECT COUNT(*) 
                        from `forums_posts`
                        where `CategoryID` = `ForumID`
                        AND `ParentID` IS NOT NULL
                        ) AS `Replies`

                    FROM `forums_threads_groups`
                    WHERE `GroupID` = :GroupID
                
                ",array([":GroupID",$Row["GroupID"],PDO::PARAM_INT]));

                foreach($Get_Threads as $Thread)
                {
                    $ForumID = $Thread["ForumID"];
                    $ForumName = $Thread["Name"];
                    $ForumAbout = $Thread["About"];
                    $ForumPosts = $Thread["Posts"];
                    $ForumReplies = $Thread["Replies"];
    
                    $Groups[$GroupID]["Content"][] = array(
                        "ForumName" => $ForumName,
                        "ForumAbout" => $ForumAbout,
                        "ForumID" => $ForumID,
                        "Posts" => $ForumPosts,
                        "Replies" => $ForumReplies,
                    );
                }
            }

            return $Groups;
            }



            /*Normal Query*/

            $Database = new Database();
            $Get = $Database->Prepare_Data_BindValue("
            SELECT *
            FROM `forums_groups`
            ");

            for($i = 0; $i < count($Get); $i++)
            {
                $x = $Get[$i]["GroupName"];
                $z = $Get[$i]["GroupID"];
                $Groups[$z] = array(
                    "Name" => $x,
                    "ID" => $z,
                );
            }

            foreach($Get as $Row)
            {
                $GroupID = $Row["GroupID"];

                $Get_Threads = $Database->Prepare_Data_BindValue("
                    SELECT *,
                        (
                        SELECT COUNT(*) 
                        from `forums_posts`
                        where `CategoryID` = `ForumID`
                        and `Deleted` = 0 
                        AND `ParentID` IS NULL
                        ) AS `Posts`,

                        (
                        SELECT COUNT(*) 
                        from `forums_posts`
                        where `CategoryID` = `ForumID`
                        AND `ParentID` IS NOT NULL
                        ) AS `Replies`

                    FROM `forums_threads_groups`
                    WHERE `GroupID` = :GroupID
                
                ",array([":GroupID",$Row["GroupID"],PDO::PARAM_INT]));

                foreach($Get_Threads as $Thread)
                {
                    $ForumID = $Thread["ForumID"];
                    $ForumName = $Thread["Name"];
                    $ForumAbout = $Thread["About"];
                    $ForumPosts = $Thread["Posts"];
                    $ForumReplies = $Thread["Replies"];
    
                    $Groups[$GroupID]["Content"][] = array(
                        "ForumName" => $ForumName,
                        "ForumAbout" => $ForumAbout,
                        "ForumID" => $ForumID,
                        "Posts" => $ForumPosts,
                        "Replies" => $ForumReplies,
                    );
                }
            }

            return $Groups;
        }

        static function IsPublic($ID = false)
        {
            $Database = new Database();

            $x = 
            $Database->FetchColumn(
                "SELECT 1 
                FROM `forums_threads_groups` 
                WHERE `ForumID` = ?"
                ,array($ID));

            if($x != 1)
            {
                throw new Exception("Requested Group Doesnt exists");
            }    


            $Execute = 
            $Database->FetchColumn(
                "SELECT 1 
                FROM `forums_threads_groups` 
                WHERE `Public` = 1 
                AND `ForumID` = ?"
                ,array($ID));

            if($Execute != 1){
                if(Session::Get_AdminLevel() == false){
                    throw new Exception("You dont have Enough perms to Open a post in this Category");
                    return false; //NO ADMIN
                }else{ 
                    return true; } //IS ADMIN
            }else{
                return true; //IS PUBLIC
            }
           
            
        }
    }

?>