<template>
	<form action="" @submit.prevent="submit">
		<h1 class="mb-1">Login Page</h1>

		<div class="alert alert-danger mb-2" v-if="errors.message">
			{{ errors.message }}
			<span class="close" @click="closeAlert">x</span>
		</div>

		<div class="input-box">
			<label for="email">Email</label>
			<input type="email" id="email" v-model="email" />
			<div v-if="errors.email">
				<p
					class="invalid-text"
					v-for="(error, idx) in errors.email"
					:key="idx"
				>
					{{ error }}
				</p>
			</div>
		</div>
		<div class="input-box mt-1">
			<label for="password">Password</label>
			<input type="password" id="password" v-model="password" />
			<div v-if="errors.password">
				<p
					class="invalid-text"
					v-for="(error, idx) in errors.password"
					:key="idx"
				>
					{{ error }}
				</p>
			</div>
		</div>
		<button class="btn mt-2">Login</button>
		<RouterLink :to="{ name: 'register' }" class="link mt-05"
			>Doesn't have an account? Register Here!</RouterLink
		>
	</form>
</template>
<script>
import { ref } from "vue";
import { fetching } from "../utils";
import { useRouter } from "vue-router";
import { APP_NAME } from "../config";
import { useStore } from "vuex";
export default {
	name: "Seidei - Login",
	setup() {
		const email = ref("");
		const password = ref("");
		const errors = ref({});
		const router = useRouter();
		const store = useStore();

		async function submit() {
			const res = await fetching("post", "auth/login", {
				data: {
					email: email.value,
					password: password.value,
				},
			});
			if (res.status == 422) {
				errors.value = res.data.errors;
				errors.value.message = res.data.message;
			} else if (res.status == 401) {
				errors.value.message = res.data.message;
			} else if (res.status == 200) {
				errors.value = {};
				localStorage.setItem(
					`${APP_NAME}_TOKEN`,
					res.data.access_token
				);
				store.commit("setUser", res.data.user);
				router.push({ name: "home" });
			}
		}

		function closeAlert() {
			errors.value.message = null;
		}

		return { email, password, submit, errors, closeAlert };
	},
};
</script>
