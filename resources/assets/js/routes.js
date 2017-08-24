import VueRouter from 'vue-router';

let routes = [
    {
        path: '/headings',
        component: require('./views/Headings'),

    },
    {
        path: '/headings/:id',
        component: require('./views/HeadingPost'),
    },
    /*{
        path: '*',
        redirect: '/headings'
    }*/
];

export default new VueRouter({
    routes: routes
})
