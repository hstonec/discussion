<?php
require_once("databaseClassMySQLi.php");

class RoleDAO {
    private $db;
    
    public function __construct() {
        $this->db = new databse();
        $this->db->connect();
    }
    public function __destruct() {
        $this->db->disconnect();
    }
    
    public function insertRole($role) {
        if (gettype($role) != "object")
            return "Wrong argument type!";
        $sql = "insert into role (id_role, role_name) ".
               "values (".$role->getRoleID().", '".$role->getRoleName()."')";
        $this->db->send_sql($sql);
        return true;
    }
    public function getRoleByID($roleID) {
        if (!is_int($roleID))
            return "Wrong argument type!";
        $sql = "select id_role, role_name from role where id_role = ".$roleID;
        $this->db->send_sql($sql);
        $row = $this->db->next_row();
        if ($row === null)
            return null;
        return new Role($row["id_role"], $row["role_name"]);
    }
    public function getRoles() {
        $sql = "select id_role, role_name from role";
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
        $sql = "update role ".
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
        $this->db = new databse();
        $this->db->connect();
        $cache = array();
    }
    public function __destruct() {
        $this->db->disconnect();
    }
    
    public function insertDepartment($department) {
        if (gettype($department) != "object")
            return "Wrong argument type!";
        $sql = "insert into department (id_department, id_parent, department_name) ".
               "values (".$department->getDepartmentID().", ".
                          $department->getParent()->getDepartmentID().", ".
                        "'".$department->getDepartmentName()."')";
        $this->db->send_sql($sql);
        return true;
    }
    public function getDepartmentByID($departmentID) {
        if (!is_int($departmentID))
            return "Wrong argument type!";
        
        if (isset($this->cache[$departmentID]))
            return $this->cache[$departmentID];
        
        $sql = "select id_department, id_parent, department_name ".
               "from department ".
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
    public function setParent($parentDepartment) {
        $this->parentDepartment = $parentDepartment;
    }
}

class UserDAO {
    private $db;
    private $roleDAO;
    private $departmentDAO;
    
    public function __construct() {
        $this->db = new databse();
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
        $sql = "insert into user ".
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
        if (!is_int($userID))
            return "Wrong argument type!";
        $sql = "select ".
               "id_user, id_role, id_department, username, password, first_name, last_name, gender, photo_url ".
               "from user ".
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
    
}

class GroupDAO {
    private $userDAO;
    private $db;
    
    public function __construct() {
        $this->userDAO = new UserDAO();
        $this->db = new databse();
        $this->db->connect();
    }
    public function __destruct() {
        $this->db->disconnect();
    }
    
    public function insertGroup($group) {
        if (gettype($group) != "object")
            return "Wrong argument type!";
        $sql = "insert into group ".
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
        $this->db = new databse();
        $this->db->connect();
    }
    public function __destruct() {
        $this->db->disconnect();
    }
    
    public function insertGroupMember($groupMember) {
        if (gettype($groupMember) != "object")
            return "Wrong argument type!";
        $sql = "insert into group_member ".
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
    
}
class Record {
    private $recordID;
    private $group;
    private $user;
    private $messageType;
    private $content;
    private $time;
    private $displayStatus;
    public function __construct() {
        
    }
}
?>