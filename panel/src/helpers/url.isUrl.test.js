import { describe, expect, it } from "vitest";
import url from "./url.js";

describe("$helper.url.isUrl", () => {
	it("should detect URL in string", () => {
		expect(url.isUrl("https://getkirby.com")).toStrictEqual(true);
		expect(url.isUrl("/foo")).toStrictEqual(true);
	});

	it("should fail on invalid input", () => {
		expect(url.isUrl(false)).toStrictEqual(false);
		expect(url.isUrl({})).toStrictEqual(false);
		expect(url.isUrl(1)).toStrictEqual(false);
	});

	it("should detect URL object", () => {
		expect(url.isUrl(new URL("https://getkirby.com"))).toStrictEqual(true);
	});

	it("should detect Location object", () => {
		expect(url.isUrl(window.location)).toStrictEqual(true);
	});
});