import { createRouter, createWebHashHistory } from "vue-router";
import Home from "@/views/Home.vue";
import About from "@/views/About.vue";
import Login from "@/views/Login.vue";
import Blog from "@/views/Blog.vue";
import Register from "@/views/Register.vue";
import CreateBlog from '@/views/CreateBlog.vue';
import SingleBlog from '@/views/SingleBlog.vue';
import { fetching } from "../utils";

const routes = [
	{
		path: "/",
		name: "home",
		component: Home,
	},
	{
		path: "/about",
		name: "about",
		component: About,
	},
	{
		path: "/",
		meta: {
			auth: true,
		},
		children: [
			{
				path: "/blog-posts/",
				name: "blog",
				component: Blog,
			},
			{
				path: "/blog-posts/:id",
				name: "single-blog",
				props: true,
				component: SingleBlog,
			},
			{
				path: "/blog-posts/tags/:slug",
				name: "tag-blog",
				props: true,
				component: Blog,
			},
			{
				path: "/blog-posts/create",
				name: "create-blog",
				component: CreateBlog,
			},
		],
	},
	{
		path: "/login",
		name: "login",
		component: Login,
		meta: {
			guest: true,
		},
	},
	{
		path: "/register",
		name: "register",
		component: Register,
		meta: {
			guest: true,
		},
	},
];

const router = createRouter({
	routes,
	history: createWebHashHistory(),
});

router.beforeEach(async function (to, from, next) {
	if (to.meta.auth) {
		const res = await fetching("get", "me");
		if (res.status == 401) {
			next({
				name: "login",
			});
		}
	}

	if (to.meta.guest) {
		const res = await fetching("get", "me");
		if (res.status != 401) {
			next({
				name: "home",
			});
		}
	}

	next();
});

export default router;
