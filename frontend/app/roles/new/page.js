// pages/roles/new.js - Create Role page
"use client";
import { useRouter } from "next/navigation";
import RoleForm from "../../../components/RoleForm";
import { rolesApi } from "../../../lib/api";
import { useState } from "react";
import toast from "react-hot-toast";

export default function NewRolePage() {
  const router = useRouter();
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  async function handleSubmit(payload) {
    setLoading(true);
    setError(null);
    try {
      // Après création
      await rolesApi.create(payload);
      toast.success("Role created successfully!");
      router.push("/roles");
    } catch (e) {
      console.error(e);
      setError(e.data?.message || e.message);
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="p-8">
      <h2 className="text-xl font-semibold mb-4">Créer Role</h2>
      {error && <div className="text-red-600 mb-2">{error}</div>}
      <RoleForm
        onSubmit={handleSubmit}
        submitLabel={loading ? "Creation..." : "Créer Role"}
      />
    </div>
  );
}
