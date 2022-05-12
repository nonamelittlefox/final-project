import Layout from '@/layout';

const scheduleManagement = {
    path: '/schedule-management',
    component: Layout,
    redirect: { name: 'ScheduleManagementList' },
    name: 'ScheduleManagement',
    meta: {
        title: 'ROUTER.SCHEDULE_MANAGEMENT',
        icon: 'fas fa-clipboard-list',
    },
    isHidden: '',
    children: [
        {
            path: 'list',
            name: 'ScheduleManagementList',
            meta: {
                title: 'ROUTER.SCHEDULE_MANAGEMENT',
            },
            component: () => import(/* webpackChunkName: "ScheduleManagementList" */ '@/pages/ScheduleManagement/list'),
        },
    ],
};

export default scheduleManagement;
