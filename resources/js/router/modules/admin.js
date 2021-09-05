/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const adminRoutes = {
  path: '/administrator',
  component: Layout,
  redirect: '/administrator/users',
  name: 'Administrator',
  alwaysShow: true,
  meta: {
    title: 'Administración',
    icon: 'admin',
    permissions: ['view menu administrator'],
  },
  children: [
    /** User managements */
    {
      path: 'personal',
      component: () =>
                import ('@/views/medicos/index'),
      name: 'MedicosList',
      meta: { title: 'Medicos', icon: 'peoples' },
    },
    {
      path: 'mascotas',
      component: () =>
                import ('@/views/species/index'),
      name: 'Mascotas',
      meta: { title: 'tipo Mascotas', icon: 'role' },
    },
    {
      path: 'users/edit/:id(\\d+)',
      component: () =>
                import ('@/views/users/UserProfile'),
      name: 'UserProfile',
      meta: { title: 'userProfile', noCache: true, permissions: ['manage user'] },
      hidden: true,
    },
    {
      path: 'users',
      component: () =>
                import ('@/views/users/List'),
      name: 'UserList',
      meta: { title: 'users', icon: 'user', permissions: ['manage user'] },
    },
    /** Role and permission */
    {
      path: 'roles',
      component: () =>
                import ('@/views/role-permission/List'),
      name: 'RoleList',
      meta: { title: 'Roles y Permisos', icon: 'role', permissions: ['manage permission'] },
    },
    {
      path: 'animals',
      component: () =>
                import ('@/views/animal/Index'),
      name: 'AnimalList',
      meta: { title: 'Animales', icon: 'role' },
    },
    /* {
            path: 'clients',
            component: () =>
                import ('@/views/client/Index'),
            name: 'ClientList',
            meta: { title: 'Clientes', icon: 'role' },
        },*/
    /* {
                path: 'articles/create',
                component: () =>
                    import ('@/views/articles/Create'),
                name: 'CreateArticle',
                meta: { title: 'createArticle', icon: 'edit', permissions: ['manage article'] },
                hidden: true,
            },
            {
                path: 'articles/edit/:id(\\d+)',
                component: () =>
                    import ('@/views/articles/Edit'),
                name: 'EditArticle',
                meta: { title: 'editArticle', noCache: true, permissions: ['manage article'] },
                hidden: true,
            },
            {
                path: 'articles',
                component: () =>
                    import ('@/views/articles/List'),
                name: 'ArticleList',
                meta: { title: 'articleList', icon: 'list', permissions: ['manage article'] },
            },*/
  ],
};

export default adminRoutes;
