/*
 * @vitest-environment happy-dom
 */

import { describe, it, expect } from "vitest";
import { mount } from "@vue/test-utils";
import MovieOrdersView from "./MovieOrdersView.vue";

const admin = {
  adress: "1 rue de la paix",
  email: "admin@gmail.com",
  roles: ["ROLE_ADMIN"],
  name: "admin",
  totalCredits: 10000,
}

describe("MovieOrdersView", () => {
  it("should render", () => {
    const wrapper = mount(MovieOrdersView, {
      global: {
        provide: {
          "currentUser": admin
        }
      }
    });
    // expect(wrapper.find("table").exists()).toBeTruthy();
    expect(wrapper.findAll("th").at(0).text()).toBe("EMAIL ACHETEUR");
    expect(wrapper.findAll("th").at(1).text()).toBe("NOM DU FILM");
    expect(wrapper.findAll("th").at(2).text()).toBe("QUANTITE");
    expect(wrapper.findAll("th").at(3).text()).toBe("PRIX");
  });
});
