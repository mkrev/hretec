function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  //{ path: '/', name: 'welcome', component: page('welcome.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

  { path: '/', name: 'home', component: page('home.vue') },
  { path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
    ] 
  },

  { path: '/create',
  component: page('contents/create/index.vue'),
  children: [
    { path: '', redirect: { name: 'settings.profile' } },
    { path: 'article', name: 'create.article', component: page('contents/create/article.vue') },
    { path: 'video', name: 'create.video', component: page('contents/create/video.vue') },
    { path: 'discussion', name: 'create.discussion', component: page('contents/create/discussion.vue') },
  ] 
},

{ path: '/edit',
component: page('contents/edit/index.vue'),
children: [
  { path: '', redirect: { name: 'settings.profile' } },
  { path: 'article/:id', name: 'edit.article', component: page('contents/create/article.vue') },
  { path: 'video/:id', name: 'edit.video', component: page('contents/create/video.vue') },
  { path: 'discussion/:id', name: 'edit.discussion', component: page('contents/create/discussion.vue') },
] 
},

{ path: '/list',
component: page('contents/list/index.vue'),
children: [
  { path: '', redirect: { name: 'settings.profile' } },
  { path: 'article', name: 'list.article', component: page('contents/list/article.vue') },
  { path: 'video', name: 'list.video', component: page('contents/list/video.vue') },
  { path: 'discussion', name: 'list.discussion', component: page('contents/list/discussion.vue') },
] 
},

  { path: '/articles', name: 'articles', component: page('contents/articles.vue') },
  { path: '/videos', name: 'videos', component: page('contents/videos.vue') },
  { path: '/discussions', name: 'discussions', component: page('contents/discussions.vue') },

  { path: '/article/:id', name: 'article', component: page('contents/detail/article.vue') },
  { path: '/video/:id', name: 'video', component: page('contents/detail/video.vue') },
  { path: '/discussion/:id', name: 'discussion', component: page('contents/detail/discussion.vue') },
  

  { path: '*', component: page('errors/404.vue') }
]
