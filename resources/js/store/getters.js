const getters = {
    language: state => state.app.language,
    userId: state => state.user.profile.id,
    name: state => state.user.profile.name,
    token: state => state.user.access_token,
    profile: state => state.user.profile,
    roles: state => state.user.profile.roles,
    permissions: state => state.user.profile.permissions,
    permissionRoutes: state => state.permissions.routes,
    addRoutes: state => state.permissions.addRoutes,
    expToken: state => state.user.profile.expToken,
    department_id: state => state.department.department_id,
    department_name: state => state.department.department_name,
    listDepartment: state => state.department.listDepartment,
};

export default getters;
