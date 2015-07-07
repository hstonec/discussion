<?php
require_once("libraries/head.php");
require_once("libraries/class.FastTemplate.php");


if (!isLogin())
    forward("login.php");

displayIndex($_SESSION["userID"]);

function displayIndex($userID) {
    $tpl = new FastTemplate("templates/");
    $tpl->define(array("web_main" => "web_main.html",
                       "web_header" => "web_header.html",
                       "head_script" => "index/head_script.html",
                       "user" => "index/user.html",
                       "department" => "index/department.html",
                       "list_item" => "index/list_item.html",
                       "group" => "index/group.html",
                       "comment" => "index/comment.html",
                       "link" => "index/link.html",
                       "image" => "index/image.html",
                       "invitation" => "index/invitation.html",
                       "body" => "index/body.html",
                       "web_nav" => "web_nav.html",
                       "web_footer" => "web_footer.html"));
    
    
    $userDAO = new UserDAO();
    $user = $userDAO->getUserByID($userID);
    
    
    //initial list item
    $gmDAO = new GroupMemberDAO();
    $gms = $gmDAO->getGroupMembersByUser($user);
    if ($gms !== null) {
        $i = 1;
        foreach($gms as $gm) {
            if ($gm->getAcceptStatus() == "2")
                continue;
            $group = $gm->getGroup();
            $tpl->assign("INDEX_LIST_ITEM_GROUPID", $group->getGroupID());
            if ($i == 1) {
                $tpl->assign("INDEX_GROUP_HEADER", $group->getGroupName());
                $tpl->assign("INDEX_LIST_ITEM_ACTIVE", "active");
            } else
                $tpl->assign("INDEX_LIST_ITEM_ACTIVE", "");
            $tpl->assign("INDEX_LIST_ITEM_SEQ", $i);
            $tpl->assign("INDEX_LIST_ITEM_GROUPNAME", $group->getGroupName());
            $tpl->parse("INDEX_LIST_ITEM_LI", ".list_item");
            
            $i++;
        }
    } else {
        $tpl->assign("INDEX_LIST_ITEM_LI", "");
        $tpl->assign("INDEX_GROUP_HEADER", "");
    }
        
    
    //initial comments
    $recordDAO = new RecordDAO();
    
    if ($gms !== null) {
        $i = 1;
        foreach($gms as $gm) {
            if ($gm->getAcceptStatus() == "2")
                continue;
            $group = $gm->getGroup();
            if ($i == 1) {
                $tpl->assign("INDEX_GROUP_HIDE", "");
            } else
                $tpl->assign("INDEX_GROUP_HIDE", "hide");
            $tpl->assign("INDEX_GROUP_SEQ", $i);
            
            $records = $recordDAO->getRecordsByGroup($group);
            if ($records === null) {
                $tpl->assign("INDEX_GROUP_COMMENT", "");
            } else {
                $tpl->clear("INDEX_GROUP_COMMENT");
                foreach($records as $rec) {
                    if ($rec->getDisplayStatus() === "2")
                        continue;
                    $commentUser = $rec->getUser();
                    $tpl->assign("INDEX_GROUP_COMMENT_USERPHOTO", $commentUser->getPhotoURL());
                    $tpl->assign("INDEX_GROUP_COMMENT_USERNAME", $commentUser->getFirstName()." ".$commentUser->getLastName());
                    $tpl->assign("INDEX_GROUP_COMMENT_TIME", $rec->getTime());        
                    
                    
                    $type = $rec->getMessageType();
                    $con = $rec->getContent();
                    if ($type == "1")
                        $tpl->assign("INDEX_GROUP_COMMENT_CONTENT", htmlentities($con));
                    else if ($type == "2") {
                        $tpl->assign("INDEX_CONTENT_IMGURL", $con);
                        $tpl->parse("INDEX_GROUP_COMMENT_CONTENT", "image");
                    } else if ($type == "3") {
                        $tpl->assign("INDEX_GROUP_CONTENT_LINKURL", $con);
                        $baseName = pathinfo($con, PATHINFO_BASENAME);
                        $pos = strpos($baseName, "_");
                        $oriName = substr($baseName, $pos + 1);
                        $tpl->assign("INDEX_GROUP_CONTENT_LINKNAME", htmlentities($oriName));
                        $tpl->parse("INDEX_GROUP_COMMENT_CONTENT", "link");
                    } else if ($type == "4") {
                        $tpl->assign("INDEX_GROUP_CONTENT_LINKURL", "http://".rawurlencode($con));
                        $tpl->assign("INDEX_GROUP_CONTENT_LINKNAME", htmlentities($con));
                        $tpl->parse("INDEX_GROUP_COMMENT_CONTENT", "link");
                    }
                    
                    $tpl->parse("INDEX_GROUP_COMMENT", ".comment");
                }
            }
            $tpl->parse("INDEX_GROUP", ".group");
            $i++;
        }
    } else {
        $tpl->assign("INDEX_GROUP_COMMENT", "");
        $tpl->parse("INDEX_GROUP", "group");
    }
    

    //initial department and user
    $result = findDepartAndUser(1, $userID);
    if (count($result) === 0)
        $tpl->assign("INDEX_DEPART_USER", "");
    else {
        foreach($result as $node) {
            if ($node["type"] == 1) {
                $tpl->assign("INDEX_DEPARTID", $node["id"]);
                $tpl->assign("INDEX_DEPART_NAME", $node["name"]);
                $tpl->parse("INDEX_DEPART_USER", ".department");
            } elseif ($node["type"] == 2) {
                $tpl->assign("INDEX_USERID", $node["id"]);
                $tpl->assign("INDEX_USER_NAME", $node["name"]);
                $tpl->parse("INDEX_DEPART_USER", ".user");
            }
        }
    }
    
    
    //initial annocement
    $flag = false;
    $gmArr = $gmDAO->getGroupMembersByUser($user);
    if ($gmArr !== null)
        foreach ($gmArr as $gmPend) {
            if ($gmPend->getAcceptStatus() == "2") {
                $gmGroup = $gmPend->getGroup();
                $gmOwner = $gmGroup->getOwner();
                $tpl->assign("INDEX_INVITATION_OWNER", $gmOwner->getFirstName()." ".$gmOwner->getLastName());
                $tpl->assign("INDEX_INVITATION_GROUPNAME", $gmGroup->getGroupName());
                $tpl->assign("INDEX_INVITATION_GROUPID", $gmGroup->getGroupID());
                $tpl->parse("INDEX_INVITATION", ".invitation");
                $flag = true;
            }
        }
    
    if ($flag === false)
        $tpl->assign("INDEX_INVITATION", "");
    
    $tpl->assign("TITLE", "Home");
    $tpl->parse("WEB_HEADER", "web_header");
    $tpl->parse("HEAD_SCRIPT", "head_script");
    $tpl->parse("WEB_NAV", "web_nav");
    $tpl->parse("BODY", ".body");
    $tpl->parse("WEB_FOOTER", "web_footer");
    $tpl->parse("MAIN", "web_main");
    $tpl->FastPrint();
}


?>