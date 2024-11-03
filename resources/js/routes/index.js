import baseLayouts from "../views/layouts/baseLayouts";
import userList from "../views/users/userList";
import pageNotFound from "../views/pageNotFound";
import editUser from "../views/editUser";
import dashboardPage from "../views/dashboardPage";
import moduleList from "../views/rbac/moduleList";
import roleList from "../views/rbac/roleList";
import roleModules from "../views/rbac/roleModules";
import rolePermissions from "../views/rbac/rolePermissions";
import configurationList from "../views/settings/configurationList";


import userDetails from "../views/users/userDetails";


const routes = [
    {
        path: '/admin/',
        component: baseLayouts,
        children: [
            {path: '404', name: '404', component:pageNotFound},
            {
                path: 'dashboard', name: 'dashboard', component: dashboardPage,
                meta: {dataUrl: 'api/dashboard',pageTitle:'Dashboard'}
            },

            {   path: 'editUser', name: 'editUser', component: editUser,
                meta: {dataUrl:'api/edit_user', pageTitle:'Edit User'}
            },
            {
                path: 'users', name: 'users', component: userList,
                meta:{dataUrl:'api/users', pageTitle:'Users'}
            },
            {
                path: 'users_details/:id', name: 'users_details', component: userDetails,
                meta:{dataUrl:'api/users/',pageTitle:'User Details'}
            },
            {
                path: 'role', name: 'role', component: roleList,
                meta:{dataUrl:'api/roles', pageTitle:'Role'}
            },
            {
                path: 'module', name: 'module', component: moduleList,
                meta:{dataUrl:'api/modules',pageTitle:'Module'}
            },
            {
                path: 'configurations', name: 'configuration', component: configurationList,
                meta:{dataUrl:'api/settings',pageTitle:'Configuration'}
            },
            {
                path: 'module_permission', name: 'module_permission', component: roleModules,
                meta:{dataUrl:'api/module_permissions',pageTitle:'Module Permission'}
            },
            {
                path: 'role_permissions', name: 'role_permissions', component: rolePermissions,
                meta:{dataUrl:'api/role_permissions', pageTitle:'Role Permission'}
            },
        ]
    },
    {path: '*', redirect: '/admin/404'},

];

export default routes;
