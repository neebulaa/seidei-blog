<template>
	<Navbar />

	<section id="page">
		<div class="container">
			<RouterView :key="$route.fullPath" />
		</div>
	</section>
</template>

<script>
import Navbar from "@/components/Navbar.vue";
export default {
	name: "Seidei - App",
	components: {
		Navbar,
	},
	setup(props, context) {
	}
};
</script>
