import MyHome from "./components/MyHome.vue";
import MySignUp from "./components/MySignUp.vue";
import MyLogin from "./components/MyLogin.vue";
import MyAddRest from "./components/MyAddRest.vue";
import MyUpdateRest from "./components/MyUpdateRest.vue";
import MyAnalytics from "./components/MyAnalytics.vue";
import MyReviewPage from "./components/MyReviewPage.vue";
import {createRouter,createWebHashHistory} from "vue-router";

const routes=[
    {
        name:'MyHome',
        component:MyHome,
        path:'/'
    },
    {
        name:'MySignUp',
        component:MySignUp,
        path:'/sign-up'
    },
    {
        name:'MyLogin',
        component:MyLogin,
        path:'/login'
    },
    {
        name:'MyAddRest',
        component:MyAddRest,
        path:'/add'
    },
    {
        name:'MyUpdateRest',
        component:MyUpdateRest,
        path:"/update/:id"
    },
    {
        name:'MyAnalytics',
        component:MyAnalytics,
        path:"/analytics"
    },
    {
        name:'MyReviewPage',
        component:MyReviewPage,
        path:"/review/:id"
    }
];

const router= createRouter({
    history:createWebHashHistory(),
    routes,
});

export default router;