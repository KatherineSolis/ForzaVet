import Vue from 'vue';
import Router from 'vue-router';

/**
 * Layzloading will create many files and slow on compiling, so best not to use lazyloading on devlopment.
 * The syntax is lazyloading, but we convert to proper require() with babel-plugin-syntax-dynamic-import
 * @see https://doc.laravue.dev/guide/advanced/lazy-loading.html
 */

Vue.use(Router);

/* Layout */
import Layout from '@/layout';

/* Router for modules */
// import tableRoutes from './modules/table';
import adminRoutes from './modules/admin';
// import permissionRoutes from './modules/permission';
// import elementUI from './modules/element-ui';

/**
 * Sub-menu only appear when children.length>=1
 * @see https://doc.laravue.dev/guide/essentials/router-and-nav.html
 **/

/**
* hidden: true                   if `hidden:true` will not show in the sidebar(default is false)
* alwaysShow: true               if set true, will always show the root menu, whatever its child routes length
*                                if not set alwaysShow, only more than one route under the children
*                                it will becomes nested mode, otherwise not show the root menu
* redirect: noredirect           if `redirect:noredirect` will no redirect in the breadcrumb
* name:'router-name'             the name is used by <keep-alive> (must set!!!)
* meta : {
    roles: ['admin', 'editor']   Visible for these roles only
    permissions: ['view menu zip', 'manage user'] Visible for these permissions only
    title: 'title'               the name show in sub-menu and breadcrumb (recommend set)
    icon: 'svg-name'             the icon show in the sidebar
    noCache: true                if true, the page will no be cached(default is false)
    breadcrumb: false            if false, the item will hidden in breadcrumb (default is true)
    affix: true                  if true, the tag will affix in the tags-view
  }
**/

export const constantRoutes = [{
        path: '/redirect',
        component: Layout,
        hidden: true,
        children: [{
            path: '/redirect/:path*',
            component: () =>
                import ('@/views/redirect/index'),
        }],
    },
    {
        path: '/login',
        component: () =>
            import ('@/views/login/index'),
        hidden: true,
    },
    {
        path: '/auth-redirect',
        component: () =>
            import ('@/views/login/AuthRedirect'),
        hidden: true,
    },
    /* {
                path: '/404',
                redirect: { name: 'Page404' },
                component: () =>
                    import ('@/views/error-page/404'),
                hidden: true,
            },
            {
                path: '/401',
                component: () =>
                    import ('@/views/error-page/401'),
                hidden: true,
            },*/
    {
        path: '',
        component: Layout,
        redirect: 'dashboard',
        children: [{
            path: 'dashboard',
            component: () =>
                import ('@/views/dashboard/index'),
            name: 'Dashboard',
            meta: { title: 'dashboard', icon: 'dashboard', noCache: false },
        }],
    },
];

export const asyncRoutes = [{
        path: '',
        component: Layout,
        children: [{
            path: 'client',
            component: () =>
                import ('@/views/client/Index'),
            name: 'client',
            meta: { title: 'Clientes', icon: 'peoples', noCache: false },
        }],
    },
    {
        path: '/mascotas',
        component: Layout,
        children: [{
                path: 'list',
                component: () =>
                    import ('@/views/pets/index'),
                name: 'pets',
                meta: { title: 'Mascotas', icon: 'qq', noCache: false },
            },
            {
                path: 'pet/edit/:id(\\d+)',
                component: () =>
                    import ('@/views/pets/UserProfile'),
                name: 'Historial',
                meta: { title: 'Historial Clinico', noCache: true },
                hidden: true,
            },
            {
                path: 'visit/new/:id(\\d+)', // When clicking this submenu, it will redirect to /#/foo/index
                name: 'newVisitt',
                component: () =>
                    import ('@/views/visit/clinic_history'),
                meta: { title: 'Visitas', icon: 'el-icon-date' }, // foo submenu
                hidden: true,
            },
        ],
    },
    {
        path: '/agenda',
        component: Layout,
        redirect: '/agenda/index',
        name: 'agenda',
        meta: {
            title: 'Agenda',
            icon: 'clipboard', // Using SVG icon
            permissions: ['view menu appointment'],
        },
        children: [
            /*{
              path: 'citas', // When clicking this submenu, it will redirect to /#/foo/index
              name: 'FullCalendar',
              component: () =>
                              import ('@/views/calendario/index'),
              meta: { title: 'Citas', icon: 'edit' }, // foo submenu
            },*/
            {
                path: 'agendar/citas', // When clicking this submenu, it will redirect to /#/foo/index
                name: 'FullCalendar1',
                component: () =>
                    import ('@/views/calendario/calendar'),
                meta: { title: 'Citas', icon: 'edit' }, // foo submenu
            },
            {
                path: 'listarcita', // When clicking this submenu, it will redirect to /#/foo/bar
                name: 'listarcita',
                component: () =>
                    import ('@/views/citas/index'),
                meta: { title: 'Listar Citas', icon: 'list' }, // bar submenu
            },
            {
                path: 'visit/new/:id(\\d+)', // When clicking this submenu, it will redirect to /#/foo/index
                name: 'newVisit',
                component: () =>
                    import ('@/views/visit/index'),
                meta: { title: 'Visitas', icon: 'el-icon-date' }, // foo submenu
                hidden: true,
            },
        ],
    },
    {
        path: '/servicio',
        component: Layout,
        redirect: '/servicio/index',
        name: 'servicio',
        meta: {
            title: 'Servicio',
            icon: 'component', // Using SVG icon
            permissions: ['view menu service'],
        },
        children: [{
                path: 'visit', // When clicking this submenu, it will redirect to /#/foo/index
                name: 'visitList',
                component: () =>
                    import ('@/views/visit/list'),
                meta: { title: 'Visitas', icon: 'el-icon-date' }, // foo submenu
            },
            {
                path: 'peluqueria', // When clicking this submenu, it will redirect to /#/foo/bar
                name: 'peluqueriaList',
                component: () =>
                    import ('@/views/peluqueria/index'),
                meta: { title: 'Peluquería', icon: 'list' }, // bar submenu
            },
            {
                path: 'peluqueria/create/:id(\\d+)',
                name: 'peluqueria',
                component: () =>
                    import ('@/views/peluqueria/create'),
                meta: { title: 'Peluqueria' },
                hidden: true,
            },
            {
                path: 'peluqueria/create-cita/:id(\\d+)',
                name: 'peluqueria111',
                component: () =>
                    import ('@/views/peluqueria/create-cita'),
                meta: { title: 'Peluqueria' },
                hidden: true,
            },
            {
                path: 'vaccine/create/:id(\\d+)',
                component: () =>
                    import ('@/views/vaccine/create'),
                meta: { title: 'Vacunación' },
                hidden: true,
            },
            {
                path: 'vaccine/create-cita/:id(\\d+)',
                component: () =>
                    import ('@/views/vaccine/create-cita'),
                meta: { title: 'Vacunación' },
                hidden: true,
            },
            {
                path: 'antiparasitic/create/:id(\\d+)',
                component: () =>
                    import ('@/views/antiparasitic/create'),
                meta: { title: 'Antiparasitario' },
                hidden: true,
            },
            {
                path: 'antiparasitic/create-cita/:id(\\d+)',
                component: () =>
                    import ('@/views/antiparasitic/create-cita'),
                meta: { title: 'Antiparasitario' },
                hidden: true,
            },
        ],
    },
    {
        path: '',
        component: Layout,
        children: [{
            path: 'vaccine',
            component: () =>
                import ('@/views/vaccine/index'),
            name: 'vacunas',
            meta: { title: 'Vacunas', icon: 'peoples', noCache: false, permissions: ['view menu vaccine'] },
        }],
    },
    {
        path: '',
        component: Layout,
        children: [{
            path: 'antiparasitaric',
            component: () =>
                import ('@/views/antiparasitic/index'),
            name: 'antiparasitaric',
            meta: { title: 'Antiparasitarios', icon: 'peoples', noCache: false, permissions: ['view menu antiparasitic'] },
        }],
    },
    adminRoutes,
    /* {
                    path: '/inventario',
                    component: Layout,
                    redirect: '/inventario/index',
                    name: 'inventario',
                    meta: {
                        title: 'Inventario',
                        icon: 'user', // Using SVG icon
                    },
                    children: [{
                            path: 'proveedores', // When clicking this submenu, it will redirect to /#/foo/index
                            component: () =>
                                import ('@/views/supplier/index'),
                            name: 'proveedoresList',
                            meta: { title: 'Proveedores', icon: 'role' }, // foo submenu
                        },
                        {
                            path: 'category', // When clicking this submenu, it will redirect to /#/foo/bar
                            component: () =>
                                import ('@/views/category/index'),
                            name: 'category',
                            meta: { title: 'Categoria', icon: 'role' }, // bar submenu
                        },
                        {
                            path: 'productos', // When clicking this submenu, it will redirect to /#/foo/bar
                            component: () =>
                                import ('@/views/products/index'),
                            name: 'producto',
                            meta: { title: 'Producto', icon: 'role' }, // bar submenu
                        },
                    ],
                },*/
    {
        path: '/404',
        component: () =>
            import ('@/views/error-page/404'),
        hidden: true,
    },
];

const createRouter = () => new Router({
    // mode: 'history', // require service support
    scrollBehavior: () => ({ y: 0 }),
    base: process.env.MIX_LARAVUE_PATH,
    routes: constantRoutes,
});

const router = createRouter();

// Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
export function resetRouter() {
    const newRouter = createRouter();
    router.matcher = newRouter.matcher; // reset router
}

export default router;