<?php
require_once("databaseClassMySQLi.php");

class RoleDAO {
    private $db;
    
    public function __construct() {
        $this->db = new database();
        $this->db->connect();
    }
    public function __destruct() {
        $this->db->disconnect();
    }
    
    public function insertRole($role) {
        if (gettype($role) != "object")
            return "Wrong argument type!";
        $sql = "insert into t_role (id_role, role_name) ".
               "values (".$role->getRoleID().", '".$role->getRoleName()."')";
        $this->db->send_sql($sql);
        return true;
    }
    public function getRoleByID($roleID) {
        if (!is_int($roleID))
            return "Wrong argument type!";
        $sql = "select id_role, role_name from t_role where id_role = ".$roleID;
        $this->db->send_sql($sql);
        $row = $this->db->next_row();
        if ($row === null)
            return null;
        return new Role($row["id_role"], $row["role_name"]);
    }
    public function getRoles() {
        $sql = "select id_role, role_name from t_role";
        $this->db->send_sql($sql);
        $row = $this->db->next_row();
        if ($row === null)
            return null;
        $arr = array();
        $arr[] = new Role($row["id_role"], $row["role_name"]);
        while ($row = $this->db->next_row()) {
            $arr[] = new Role($row["id_role"], $row["role_name"]);
        }
        return $arr;
    }
    public function updateRole($role) {
        if (gettype($role) != "object")
            return "Wrong argument type!";
        $sql = "update t_role ".
               "set role_name = '".$role->getRoleName()."' ".
               "where id_role = ".$role->getRoleID();
        $this->db->send_sql($sql);
        return true;
    }
}
class Role {
    private $roleID;
    private $roleName;
    
    public function __construct($roleID, $roleName) {
        $this->roleID = $roleID;
        $this->roleName = $roleName;
    }
    public function setRoleName($roleName) {
        $this->roleName = $roleName;
    }
    public function getRoleName() {
        return $this->roleName;
    }
    public function getRoleID() {
        return $this->roleID;
    }
}

class DepartmentDAO {
    private $db;
    private $cache;
    
    public function __construct() {
        $this->db = new database();
        $this->db->connect();
        $cache = array();
    }
    public function __destruct() {
        $this->db->disconnect();
    }
    
    public function insertDepartment($department) {
        if (gettype($department) != "object")
            return "Wrong argument type!";
        $sql = "insert into t_department (id_department, id_parent, department_name) ".
               "values (".$department->getDepartmentID().", ".
                          $department->getParent()->getDepartmentID().", ".
                        "'".$department->getDepartmentName()."')";
        $this->db->send_sql($sql);
        $department->setDepartmentID($this->db->insert_id());
        return true;
    }
    public function getDepartmentByID($departmentID) {
        if (!is_int($departmentID))
            return "Wrong argument type!";
        
        if (isset($this->cache[$departmentID]))
            return $this->cache[$departmentID];
        
        $sql = "select id_department, id_parent, department_name ".
               "from t_department ".
               "where id_department = ".$departmentID;
        $this->db->send_sql($sql);
        $row = $this->db->next_row();
        if ($row === null)
            return null;
        
        if ($row["id_department"] === $row["id_parent"])
            $par = null;
        else
            $par = $this->getDepartmentByID($row["id_department"]);
        
        $this->cache[$departmentID] = new Department($par, $row["department_name"], $row["id_department"]);
        return $this->cache[$departmentID];
    }
}
class Department {
    private $departmentID;
    private $parentDepartment;
    private $departmentName;
    
    public function __construct($parentDepartment, $departmentName, $departmentID = null) {
        $this->parentDepartment = $parentDepartment;
        $this->departmentName = $departmentName;
        $this->departmentID = $departmentID;
    }
    
    public function setDepartmentID($departmentID) {
        $this->departmentID = $departmentID;
    }
    public function setParent($parentDepartment) {
        $this->parentDepartment = $parentDepartment;
    }
    public function setDepartmentName($departmentName) {
        $this->departmentName = $departmentName;
    }
    public function getDepartmentName() {
        return $this->departmentName;
    }
    public function getDepartmentID() {
        return $this->departmentID;
    }
    public function getParent() {
        return $this->parentDepartment;
    }
    
}

class UserDAO {
    private $db;
    private $roleDAO;
    private $departmentDAO;
    
    public function __construct() {
        $this->db = new database();
        $this->db->connect();
        
        $this->roleDAO = new RoleDAO();
        $this->departmentDAO = new DepartmentDAO();
    }
    public function __destruct() {
        $this->db->disconnect();
    }
    
    public function insertUser($user) {
        if (gettype($user) != "object")
            return "Wrong argument type!";
        $sql = "insert into t_user ".
               "(id_role, id_department, username, password, first_name, last_name, gender, photo_url) ".
               "values (".
                   $user->getRole()->getRoleID().", ".
                   $user->getDepartment()->getDepartmentID().", ".
                   "'".$user->getUsername()."', ".
                   "'".$user->getPassword()."', ".
                   "'".$user->getFirstName()."', ".
                   "'".$user->getLastName()."', ".
                   $user->getGender().", ".
                   "'".$user->getPhotoUrl()."'".
               ")";
        $this->db->send_sql($sql);
        $user->setUserID($this->db->insert_id());
        return true;
    }
    public function getUserByID($userID) {
        $userID = (int)$userID;
        $sql = "select ".
               "id_user, id_role, id_department, username, password, first_name, last_name, gender, photo_url ".
               "from t_user ".
               "where id_user = ".$userID;
        $this->db->send_sql($sql);
        $row = $this->db->next_row();
        if ($row === null)
            return null;
        $role = $this->roleDAO->getRoleByID($row["id_role"]);
        $department = $this->departmentDAO->getDepartmentByID($row["id_department"]);
        return new User($role,
                       $department,
                       $row["username"],
                       $row["password"],
                       $row["first_name"],
                       $row["last_name"],
                       $row["gender"],
                       $row["photo_url"],
                       $userID);
    }
    public function getUserByUP($username, $password) {
        if (gettype($username) != "string" || gettype($password) != "string")
            return "Wrong argument type!";
        $sql = "select ".
               "id_user, id_role, id_department, username, password, first_name, last_name, gender, photo_url ".
               "from t_user ".
               "where username = '".$username."' and password = '".$password."'";
        $this->db->send_sql($sql);
        $row = $this->db->next_row();
        if ($row === null)
            return null;
        $role = $this->roleDAO->getRoleByID($row["id_role"]);
        $department = $this->departmentDAO->getDepartmentByID($row["id_department"]);
        return new User($role,
                       $department,
                       $row["username"],
                       $row["password"],
                       $row["first_name"],
                       $row["last_name"],
                       $row["gender"],
                       $row["photo_url"],
                       $row["id_user"]);
    }
    
}
class User {
    private $userID;
    private $role;
    private $department;
    private $username;
    private $password;
    private $firstName;
    private $lastName;
    private $gender;
    private $photoURL;
    
    public function __construct($role, 
                       $department, 
                       $username, 
                       $password, 
                       $firstName,
                       $lastName,
                       $gender,
                       $photoURL,
                       $userID = null) {
        $this->role = $role;
        $this->department = $department;
        $this->username = $username;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->photoURL = $photoURL;
        $this->userID = $userID;
    }
    public function getUserID() {
        return $this->userID;
    }
    public function getRole() {
        return $this->role;
    }
    public function getDepartment() {
        return $this->department;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getFirstName() {
        return $this->firstName;
    }
    public function getLastName() {
        return $this->lastName;
    }
    public function getGender() {
        return $this->gender;
    }
    public function getPhotoURL() {
        return $this->photoURL;
    }
    
    public function setUserID($userID) {
        $this->userID = $userID;
    }
    public function setRole($role) {
        $this->role = $role;
    }
    public function setDepartment($department) {
        $this->department = $department;
    }
    public function setUsername($username) {
        $this->username = $username;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }
    public function setGender($gender) {
        $this->gender = $gender;
    }
    public function setPhotoURL($photoURL) {
        $this->photoURL = $photoURL;
    }
}

class GroupDAO {
    private $userDAO;
    private $db;
    
    public function __construct() {
        $this->userDAO = new UserDAO();
        $this->db = new database();
        $this->db->connect();
    }
    public function __destruct() {
        $this->db->disconnect();
    }
    
    public function insertGroup($group) {
        if (gettype($group) != "object")
            return "Wrong argument type!";
        $sql = "insert into t_group ".
               "(id_owner, group_name, activate_status) ".
               "values (".
                   $group->getOwner()->getUserID().", ".
                   "'".$group->getGroupName()."', ".
                   $group->getActivateStatus().")";
        $this->db->send_sql($sql);
        $group->setGroupID($this->db->insert_id());
        return true;
    }
}
class Group {
    private $groupID;
    private $owner;
    private $groupName;
    private $activateStatus;
    
    public function __construct($owner, $groupName, $activateStatus, $groupID = null) {
        $this->owner = $owner;
        $this->groupName = $groupName;
        $this->activateStatus = $activateStatus;
        $this->groupID = $groupID;
    }
    public function getGroupID() {
        return $this->groupID;
    }
    public function getOwner() {
        return $this->owner;
    }
    public function getGroupName() {
        return $this->groupName;
    }
    public function getActivateStatus() {
        return $this->activateStatus;
    }
    
    public function setGroupID($groupID) {
        $this->groupID = $groupID;
    }
    public function setOwner($owner) {
        $this->owner = $owner;
    }
    public function setGroupName($groupName) {
        $this->groupName = $groupName;
    }
    public function setActivateStatus($activateStatus) {
        $this->activateStatus = $activateStatus;
    }
}

class GroupMemberDAO {
    private $db;
    
    public function __construct() {
        $this->db = new database();
        $this->db->connect();
    }
    public function __destruct() {
        $this->db->disconnect();
    }
    
    public function insertGroupMember($groupMember) {
        if (gettype($groupMember) != "object")
            return "Wrong argument type!";
        $sql = "insert into t_group_member ".
               "(id_group, id_user, accept_status) ".
               "values (".
                   $groupMember->getGroup()->getGroupID().", ".
                   $groupMember->getUser()->getUserID().", ".
                   $groupMember->getAcceptStatus().")";
        $this->db->send_sql($sql);
        return true;
    }
}
class GroupMember {
    private $group;
    private $user;
    private $acceptStatus;
    
    public function __construct($group, $user, $acceptStatus) {
        $this->group = $group;
        $this->user = $user;
        $this->acceptStatus = $acceptStatus;
    }
    public function getGroup() {
        return $this->group;
    }
    public function getUser() {
        return $this->user;
    }
    public function getAcceptStatus() {
        return $this->acceptStatus;
    }
    public function setAcceptStatus($acceptStatus) {
        $this->acceptStatus = $acceptStatus;
    }
}

class RecordDAO {
    private $db;
    
    public function __construct() {
        $this->db = new database();
        $this->db->connect();
    }
    public function __destruct() {
        $this->db->disconnect();
    }
    
    public function insertRecord($record) {
        if (gettype($record) != "object")
            return "Wrong argument type!";
        $sql = "insert into t_record ".
               "(id_group, id_user, message_type, content, time, display_status) ".
               "values (".
                   $record->getGroup()->getGroupID().", ".
                   $record->getUser()->getUserID().", ".
                   $record->getMessageType().", ".
                   "'".$record->getContent()."', ".
                   "'".$record->getTime()."', ".
                   $record->getDisplayStatus().")";
        $this->db->send_sql($sql);
        $record->setRecordID($this->db->insert_id());
        return true;
    }
}
class Record {
    private $recordID;
    private $group;
    private $user;
    private $messageType;
    private $content;
    private $time;
    private $displayStatus;
    public function __construct($group, $user, $messageType, $content, $time, $displayStatus, $recordID = null) {
        $this->group = $group;
        $this->user = $user;
        $this->messageType = $messageType;
        $this->content = $content;
        $this->time = $time;
        $this->displayStatus = $displayStatus;
        $this->recordID = $recordID;
    }
    
    public function getRecordID() {
        return $this->recordID;
    }
    public function getGroup() {
        return $this->group;
    }
    public function getUser() {
        return $this->user;
    }
    public function getMessageType() {
        return $this->messageType;
    }
    public function getContent() {
        return $this->content;
    }
    public function getTime() {
        return $this->time;
    }
    public function getDisplayStatus() {
        return $this->displayStatus;
    }
    
    public function setRecordID($recordID) {
        $this->recordID = $recordID;
    }
    public function setGroup($group) {
        $this->group = $group;
    }
    public function setUser($user) {
        $this->user = $user;
    }
    public function setMessageType($messageType) {
        $this->messageType = $messageType;
    }
    public function setContent($content) {
        $this->content = $content;
    }
    public function setTime($time) {
        $this->time = $time;
    }
    public function setDisplayStatus($displayStatus) {
        $this->displayStatus = $displayStatus;
    }
}

?>