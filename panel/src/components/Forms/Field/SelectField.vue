<template>
	<k-field v-bind="$props" :input="_uid" class="k-select-field">
		<k-input
			v-bind="$props"
			:id="_uid"
			ref="input"
			theme="field"
			type="select"
			v-on="$listeners"
		/>
	</k-field>
</template>

<script>
import { props as Field } from "../Field.vue";
import { props as Input } from "../Input.vue";
import { props as SelectInput } from "../Input/SelectInput.vue";

/**
 * Have a look at `<k-field>`, `<k-input>` and `<k-select-input>` for additional information.
 */
export default {
	mixins: [Field, Input, SelectInput],
	inheritAttrs: false,
	props: {
		icon: {
			type: String,
			default: "angle-down"
		}
	},
	methods: {
		focus() {
			this.$refs.input.focus();
		}
	}
};
</script>
