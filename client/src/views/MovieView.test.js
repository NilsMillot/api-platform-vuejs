/*
 * @vitest-environment happy-dom
 */

import { describe, it, expect } from "vitest";
import { mount } from "@vue/test-utils";
import MovieView from "./MovieView.vue";

const admin = {
  adress: "1 rue de la paix",
  email: "admin@gmail.com",
  roles: ["ROLE_ADMIN"],
  name: "admin",
  totalCredits: 10000,
}

const cinema = {
  adress: "1 rue de la paix",
  email: "cinema@gmail.com",
  roles: ["ROLE_CINEMA"],
  name: "cinema",
  totalCredits: 10000,
}

const user = {
  adress: "1 rue de la paix",
  email: "user@gmail.com",
  roles: ["ROLE_USER"],
  name: "user",
  totalCredits: 0
}

describe("Test Stock-Gestion section visibility", () => {
  it("user with role ADMIN should see stock-gestion section", async () => {
    const wrapper = mount(MovieView, {
      global: {
        provide: {
          "currentUser": admin
        }
      }
    });

    expect(wrapper.find(".stock-gestion").exists()).toBeTruthy();
  });

    it("user with role CINEMA should not see stock-gestion section", () => {
      const wrapper = mount(MovieView, {
        global: {
          provide: {
            "currentUser": cinema
          }
        }
      });
      expect(wrapper.find(".stock-gestion").exists()).toBeFalsy();
    });

  it("user with role USER should not see stock-gestion section", () => {
    const wrapper = mount(MovieView, {
      global: {
        provide: {
          "currentUser": user
        }
      }
    });
    expect(wrapper.find(".stock-gestion").exists()).toBeFalsy();
  });

  it("user with role USER should not see stock-gestion section", () => {
    const wrapper = mount(MovieView, {
      global: {
        provide: {
          "currentUser": user
        }
      }
    });
    expect(wrapper.find(".stock-gestion").exists()).toBeFalsy();
  });
});

describe("Test Payment section visibility", () => {
  it("user with role USER should see Payment section", () => {
    const wrapper = mount(MovieView, {
      global: {
        provide: {
          "currentUser": user
        }
      }
    });
    expect(wrapper.find(".payment-section").exists()).toBeTruthy();
  });
  it("user with role ADMIN should see Payment section", async () => {
    const wrapper = mount(MovieView, {
      global: {
        provide: {
          "currentUser": admin
        }
      }
    });

    expect(wrapper.find(".payment-section").exists()).toBeFalsy();
  });

  it("user with role CINEMA should not see Payment section", () => {
    const wrapper = mount(MovieView, {
      global: {
        provide: {
          "currentUser": cinema
        }
      }
    });
    expect(wrapper.find(".payment-section").exists()).toBeFalsy();
  });
});