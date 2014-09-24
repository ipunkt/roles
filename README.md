ipunkt/roles
==================

# About

Role based permission checking for ipunkt/permissions

## Install

Add to your composer.json following lines

	"require": {
		"ipunkt/roles": "dev-master"
	}

## Configuration

Add 

    'Ipunkt\Roles\RolesServiceProvider'
    
to your service provider list.

Migrate by doing

    php artisan migrate --package=ipunkt/roles

## How it works

- A resource type has actions which can be performed on it.
- A Role has permissions to perform actions.
- A permission can affect the whole resource type or just a single resource
- A permission on a single resource takes precedence over a permission on the whole resource type
- A User has Roles.

### Special Names

The name `\*` is special both for actions and resources.  
When used for actions, it will match all actions  
When used for resources, it will match all resources  

Note however that other more specific permissions take precedence over this.
Example:  
Role Subadmin has permission allowing to do '\*' on '\*'
Role Subadmin has permission forbidding to do '\*' on 'supersecrettable'

$userWithSubadmin->can('anything', $superSecretModel) will return false, because \*.supersecrettable is more specific than \*.\*

## Use

### Checking Permissions
`Ipunkt\Roles\PermissionChecker\RolePermissionChecker` will be set as the default permission checker for `ipunkt\permissions`
unless you disable it in the config.

There are 3 ways to use this package

- Commands
- Web Interface
- Through the repositories

### Commands

command                 | parameters                    | description
------------------------|-------------------------------|------------
resource:make           | resource name                 | Creates a new resource with the given name
resource:list           |                               | Lists all resources
resource:destroy        | resource id                   | Destroy the resource with the given id
resource:addaction      | resource id, action name      | Add an action with the given name to the resource with the given id
resource:listactions    | resource id                   | List all actions the resource with the given id has
resource:removeaction   | resource id, action name      | Remove the action with the given name on the resource with the given id
roles:superuser         | user id                       | Assign the role 'Superuser' to the given user which has permission to do '\*' on '\*'. If necessary this roles will be created

### Web Interface

The web interface protects itself through ipunkt/permissions, so make sure you have permission to do \* on resources and roles.  
TODO: config variable to disable the web interface entirely

#### Resources
Access /permissions/privilege or the route permissions.privilege.index

#### Creating Roles
Access /permissions/role or the route permissions.role.index

### Through the repositories
`Ipunkt\Roles\Roles\RoleRepositoryInterface` is injected with the repository to work with roles.
`Ipunkt\Roles\Resources\ResourceRepositoryInterface` is injected with the repository to work with resources.

## Advanced Use
It is theoreticaly possible to switch out the default eloquent roles to something else by implementing the RoleInterface,
PermissionInterface and PrivilegeInterface for a different ORM/Database and replacing the repositories. However this remains
untested.

### Assigning Roles
There is a package ipunkt/auth-roles which connects these roles with ipunkt/auth users and brings an interface to
assign roles to them.

If you wish to implement your own connection to a user model make sure to overwrite
Ipunkt\Permissions\Repositories\RoleRepositoryInterface in the IoC.
The simplest way to do this is extend EloquentRoleRepository and override allByUserId($id)
