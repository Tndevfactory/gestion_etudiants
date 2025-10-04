export const API_BASE = process.env.NEXT_PUBLIC_API_URL || "";

export async function apiFetch(path, opts = {}) {
  const url = `${API_BASE}${path}`;
  const token = localStorage.getItem("auth_token"); // récupère le token

  const headers = {
    Accept: "application/json",
    "Content-Type": "application/json",
    ...(token ? { Authorization: `Bearer ${token}` } : {}),
    ...(opts.headers || {}),
  };

  const merged = { headers, ...opts };

  const res = await fetch(url, merged);
  const text = await res.text();
  let data;
  try {
    data = text ? JSON.parse(text) : null;
  } catch (e) {
    data = text;
  }

  if (!res.ok) {
    const err = new Error("API error");
    err.status = res.status;
    err.data = data;
    throw err;
  }
  return data;
}

export const rolesApi = {
  list: () => apiFetch("/api/roles"),
  create: (payload) =>
    apiFetch("/api/roles", { method: "POST", body: JSON.stringify(payload) }),
  get: (id) => apiFetch(`/api/roles/${id}`),
  update: (id, payload) =>
    apiFetch(`/api/roles/${id}`, {
      method: "PUT",
      body: JSON.stringify(payload),
    }),
  remove: (id) => apiFetch(`/api/roles/${id}`, { method: "DELETE" }),
};

export const authApi = {
  login: async (email, password) => {
    const res = await fetch(`${API_BASE}/api/login`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
      body: JSON.stringify({ email, password }),
    });
    const data = await res.json();
    if (!res.ok) throw new Error(data.message || "Login failed");

    // stocker le token côté client
    localStorage.setItem("auth_token", data.access_token);
    return data;
  },
  logout: () => localStorage.removeItem("auth_token"),
};
