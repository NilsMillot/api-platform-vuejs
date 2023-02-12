/*
 * @vitest-environment happy-dom
 */

import { describe, it, expect } from "vitest";
import { mount } from "@vue/test-utils";
import Login from "./Login.vue";

describe("Login", () => {
  it("should render", () => {
    const wrapper = mount(Login);
    // example to find element in dom
    // expect(wrapper.html()).toContain("S'identifier");
    // has h3 in dom
    expect(wrapper.find("h3").exists()).toBeTruthy();
    // has two inputs in dom
    expect(wrapper.findAll("input").length).toBe(2);
    // has one button in dom
    expect(wrapper.findAll("button").length).toBe(1);
    // has two links in dom
    expect(wrapper.findAll("a").length).toBe(2);
  });

  it("should have right infos", () => {
    const wrapper = mount(Login);
    // has right title
    expect(wrapper.find("h3").text()).toBe("S'identifier");
    // there is two links and one of them has link to register
    expect(wrapper.findAll("a").at(1).attributes("href")).toBe("/register");
  });
});
