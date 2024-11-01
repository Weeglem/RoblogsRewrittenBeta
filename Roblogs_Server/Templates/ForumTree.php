<?php
function ForumTree(
    $ReferenceID = false,
    $Type = "ShowPost",
    $Start = true,
    $New = ""
){
    
    $DrawArray = array(0 => array("Link" => "index.php","Name" => "ROBLOGS Forums"),);

    if($ReferenceID != false)
    {
        switch($Type)
        {
            case "ShowForumGroup":
                if($ReferenceID == false){break;}

                $Database = new Database();
                $Thread = $Database->Prepare_Data_BindValue("
                    SELECT 

                    forums_groups.GroupID AS `ParentID`,
                    forums_groups.GroupName AS `ParentName`

                    FROM `forums_groups`

                    WHERE forums_groups.GroupID = :ThreadID
                    
                "
                ,array(
                    [":ThreadID",$ReferenceID,PDO::PARAM_INT]
                ));

                if(count($Thread) == 0 ){break;}

                $DrawArray[] = array(
                    "Link" => "./ShowForumGroup.php?id=".$Thread[0]["ParentID"],
                    "Name" => $Thread[0]["ParentName"]
                );

            break;

            case "EditPost":
            case "ShowForum":
            
                if($ReferenceID == false){break;}
                $Database = new Database();
                $Thread = $Database->Prepare_Data_BindValue("
                    SELECT 

                    forums_threads_groups.Name AS `GroupName`,
                    forums_threads_groups.ForumID AS `GroupID`,
                    forums_threads_groups.GroupID AS `GroupCategory`,

                    forums_groups.GroupID AS `ParentID`,
                    forums_groups.GroupName AS `ParentName`

                    FROM `forums_threads_groups`

                    JOIN forums_groups
                    ON forums_groups.GroupID = forums_threads_groups.GroupID
                    

                    WHERE forums_threads_groups.ForumID = :ThreadID
                    
                "
                ,array(
                    [":ThreadID",$ReferenceID,PDO::PARAM_INT]
                ));

                if(count($Thread) == 0 ){break;}

                $DrawArray[] = array(
                    "Link" => "./ShowForumGroup.php?id=".$Thread[0]["ParentID"],
                    "Name" => $Thread[0]["ParentName"]
                );

                $DrawArray[] = array(
                    "Link" => "./ShowForum.php?id=".$Thread[0]["GroupID"],
                    "Name" => $Thread[0]["GroupName"]
                );
                

            break;

            case "ShowPost":
                if($ReferenceID == false){break;}

                $Database = new Database();
                $Thread = $Database->Prepare_Data_BindValue("
                    SELECT 
                    
                    `forums_posts`.`Name` AS `ThreadName`,
                    `forums_posts`.`ID` as `ThreadID`,

                    `forums_threads_groups`.`Name` AS `GroupName`,
                    `forums_threads_groups`.`ForumID` AS `GroupID`,
                    `forums_threads_groups`.`GroupID` AS `GroupCategory`,

                    forums_groups.GroupID AS `ParentID`,
                    forums_groups.GroupName AS `ParentName`

                    FROM `forums_posts` 

                    JOIN `forums_threads_groups`
                    ON `forums_threads_groups`.`ForumID` = `forums_posts`.`CategoryID`

                    JOIN `forums_groups`
                    ON `forums_groups`.`GroupID` = `forums_threads_groups`.`GroupID`
                    

                    
                     
                    WHERE forums_posts.ID = :ThreadID
                    
                "
                ,array(
                    [":ThreadID",$ReferenceID,PDO::PARAM_INT]
                ));

                if(count($Thread) == 0 ){break;}

                //var_dump($Thread);

                $DrawArray[] = array(
                    "Link" => "./ShowForumGroup.php?id=".$Thread[0]["ParentID"],
                    "Name" => $Thread[0]["ParentName"]
                );

                $DrawArray[] = array(
                    "Link" => "./ShowForum.php?id=".$Thread[0]["GroupID"],
                    "Name" => $Thread[0]["GroupName"]
                );

                $DrawArray[] = array(
                    "Link" => "./ShowPost.php?id=".$Thread[0]["ThreadID"],
                    "Name" => $Thread[0]["ThreadName"]
                );

            break;

            default:
            break;
        }
    }

    switch($New)
    {
        case "New":
            $DrawArray[] = array(
                "Link" => "#",
                "Name" => "New Message"
            );
        break;
        case "Reply":
            $DrawArray[] = array(
                "Link" => "#",
                "Name" => "New Reply"
            );
        break;
        case "Edit":
            $DrawArray[] = array(
                "Link" => "#",
                "Name" => "Edit Post"
            );
        break;
        default:
        break;
    }

    //DRAW TO SCREEN LOOP
    
    echo "<div class='ForumNav'>";

    for($i = 0; $i < count($DrawArray); $i++)
    {        
        if(isset($DrawArray[$i+1]))
        {
            echo "<span><a href='".$DrawArray[$i]["Link"]."' class='ForumNamText LinkOrangeBlue' >".$DrawArray[$i]["Name"]."</a></span>"; 
            echo "<span class='ForumNamText'> > </span>";
        }else{
            echo "<span class='ForumNamText LinkBlueUnderline actualNavLink' >".Website::MaxLength($DrawArray[$i]["Name"],33)."</span>";
        
        }
    }

    echo "</div>";
}
?>