# Ipunkt\Permissions

Ipunkt\Permissions brings a role based system to give out permissions to users.

## Install
Require with composer, migrate database

### Creating Privileges
Access /permissions/privilege or the route permissions.privilege.index

While the naming of privileges are theoreticaly free it is recommended to use the same name as the table they grant
access on.

Create a privilege and add actions to it.

The special name '*' can be used both as privilege and as action to grant privileges on all tables/actions of the given table

### Creating Roles
Access /permissions/role or the route permissions.role.index

View, then edit the created role to add permissions to it.

### Assigning Roles to Users
Is outside the scope of this package, see ipunkt/auth and ipunkt/auth-roles

### Connect Roles to Users
There is a package ipunkt/auth-roles which connects these roles with ipunkt/auth users and brings an interface to
assign roles to them.

If you wish to implement your own connection to a user model make sure to overwrite
Ipunkt\Permissions\Repositories\RoleRepositoryInterface in the IoC.
The simplest way to do this is extend EloquentRoleRepository and override allByUserId($id)

## Check Permissions
This package sets a new default PermissionChecker unless it gets disabled in the config.

This new 'RolePermissionChecker' checks if the given user has permissions on the models table -> container, id -> id,
action -> as given throughout its roles.

Since permissions can both allow and deny it is important to understand the order of priority in which permissions take
precedence. Ordered, starting with most important:

1. Permission denied on specific id
2. Permission allowed on specific id
3. Permission denied on container
4. permission allowed on container

if none of these apply the default value will be returned as give to $user->can('action', $model, defaultValue(false if not given));
NOTE: Not yet implemented

## Using non-eloquent roles
It is theoreticaly possible to switch out the default eloquent roles to something else by implementing the RoleInterface,
PermissionInterface and PrivilegeInterface for a different ORM/Database and replacing the repositories. However this remains
untested.
