// pages/roles/[id].js - Edit Role page
"use client";
import { useRouter, useParams } from "next/navigation";
import { useEffect, useState } from "react";
import RoleForm from "../../../components/RoleForm";
import { rolesApi } from "../../../lib/api";
import toast from "react-hot-toast";
import { ClipLoader } from "react-spinners"; // loader

export default function EditRolePage() {
  const router = useRouter();
  const { id } = useParams();
  const [role, setRole] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [saving, setSaving] = useState(false);

  useEffect(() => {
    let isMounted = true;
    rolesApi
      .get(id)
      .then((data) => {
        if (isMounted) setRole(data);
      })
      .catch((err) => {
        console.error(err);
        if (isMounted) setError("Failed to load role");
      })
      .finally(() => {
        if (isMounted) setLoading(false);
      });
    return () => {
      isMounted = false;
    };
  }, [id]);

  async function handleSubmit(payload) {
    setSaving(true);
    setError(null);
    try {
      // Après modification
      await rolesApi.update(id, payload);
      toast.success("Role updated successfully!");
      router.push("/roles");
    } catch (e) {
      console.error(e);
      setError(e.data?.message || e.message);
    } finally {
      setSaving(false);
    }
  }

  if (loading)
    return (
      <div className="flex justify-center items-center mt-20">
        <ClipLoader size={60} color="#2563eb" /> {/* loader bleu */}
      </div>
    );
  if (error) return <div className="text-red-600">{error}</div>;
  if (!role) return <div>Role not found</div>;
  console.log("role", role);
  return (
    <div className="p-8">
      <h2 className="text-xl font-semibold mb-4">Editer Role</h2>
      <RoleForm
        onSubmit={handleSubmit}
        initialData={role}
        submitLabel={saving ? "Enregistrement..." : "Sauvegarder"}
      />
    </div>
  );
}
