"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var vue_router_1 = require("vue-router");
var ArticleList_vue_1 = require("../components/ArticleList.vue");
var ArticleDetail_vue_1 = require("../components/ArticleDetail.vue");
var routes = [
    { path: '/', name: 'Home', component: ArticleList_vue_1.default },
    {
        path: '/article/:id',
        name: 'ArticleDetail',
        component: ArticleDetail_vue_1.default,
        props: true,
        key: function (route) { return route.params.id; }, // Clé basée sur l'ID
    },
];
var router = (0, vue_router_1.createRouter)({
    history: (0, vue_router_1.createWebHistory)(),
    routes: routes,
});
exports.default = router;
