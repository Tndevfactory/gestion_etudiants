"use client";
import React, { useState } from "react";

export default function RoleForm({
  initialData = {},
  onSubmit,
  submitLabel = "Sauvegarder",
}) {
  console.log("initialData", initialData);
  const [name, setName] = useState(initialData.name || "");
  const [description, setDescription] = useState(initialData.description || "");
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  async function handleSubmit(e) {
    e.preventDefault();
    setError(null);
    setLoading(true);
    try {
      await onSubmit({ name, description });
    } catch (err) {
      setError(err?.message || "Failed");
    } finally {
      setLoading(false);
    }
  }

  return (
    <form onSubmit={handleSubmit} className="space-y-4 max-w-md">
      {error && <div className="text-red-600">{error}</div>}
      <div>
        <label className="block text-sm font-medium">Nom</label>
        <input
          value={name}
          onChange={(e) => setName(e.target.value)}
          required
          className="mt-1 block w-full rounded border px-3 py-2"
        />
      </div>
      <div>
        <label className="block text-sm font-medium">Description</label>
        <textarea
          value={description}
          onChange={(e) => setDescription(e.target.value)}
          className="mt-1 block w-full rounded border px-3 py-2"
        />
      </div>
      <div>
        <button
          disabled={loading}
          className="px-4 py-2 rounded bg-blue-600 text-white"
        >
          {loading ? "Enregistrement..." : submitLabel}
        </button>
      </div>
    </form>
  );
}
