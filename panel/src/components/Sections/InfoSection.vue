<template>
	<section class="k-info-section">
		<k-headline class="k-info-section-label">
			{{ label }}
		</k-headline>
		<k-box :theme="theme">
			<k-text :html="text" />
		</k-box>
	</section>
</template>

<script>
import SectionMixin from "@/mixins/section.js";
export default {
	mixins: [SectionMixin],
	data() {
		return {
			label: null,
			text: null,
			theme: null
		};
	},
	async created() {
		const response = await this.load();
		this.label = response.label;
		this.text = response.text;
		this.theme = response.theme || "info";
	}
};
</script>

<style>
.k-info-section-label {
	margin-bottom: 0.5rem;
}
</style>
