<template>
	<k-dialog
		ref="dialog"
		class="k-users-dialog"
		size="medium"
		@cancel="$emit('cancel')"
		@submit="submit"
	>
		<template v-if="issue">
			<k-box :text="issue" theme="negative" />
		</template>

		<template v-else>
			<k-input
				v-if="options.search"
				:autofocus="true"
				:placeholder="$t('search') + ' …'"
				:value="search"
				type="text"
				class="k-dialog-search"
				icon="search"
				@input="search = $event"
			/>

			<k-collection v-bind="collection" @item="toggle" @paginate="paginate">
				<template #options="{ item: user }">
					<k-button v-bind="toggleBtn(user)" @click="toggle(user)" />
				</template>
			</k-collection>
		</template>
	</k-dialog>
</template>

<script>
import picker from "@/mixins/picker/dialog.js";

export default {
	mixins: [picker],
	computed: {
		emptyProps() {
			return {
				icon: "users",
				text: this.$t("dialog.users.empty")
			};
		}
	},
	methods: {
		item(item) {
			return {
				...item,
				key: item.email,
				info: item.info !== item.text ? item.info : null
			};
		}
	}
};
</script>

<style>
.k-users-dialog .k-list-item {
	cursor: pointer;
}
</style>
