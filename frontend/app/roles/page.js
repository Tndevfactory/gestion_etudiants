"use client";
import { useEffect, useState } from "react";
import { rolesApi, authApi } from "../../lib/api";
import Link from "next/link";
import { useRouter } from "next/navigation";
import toast from "react-hot-toast";
import { ClipLoader } from "react-spinners"; // loader

export default function RolesPage() {
  const router = useRouter();
  const [roles, setRoles] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const fetchRoles = () => {
    setLoading(true);
    setError(null);
    rolesApi
      .list()
      .then((data) => setRoles(data))
      .catch((err) => {
        console.error(err);
        setError("Failed to load roles");
      })
      .finally(() => setLoading(false));
  };

  useEffect(() => {
    fetchRoles();
  }, []);

  const handleDelete = async (id) => {
    const confirmDelete = await new Promise((resolve) => {
      toast(
        (t) => (
          <div className="flex flex-col gap-2">
            <span>Voulez vous supprimer ce role ?</span>
            <div className="flex gap-2">
              <button
                className="bg-red-600 text-white px-2 py-1 rounded"
                onClick={() => {
                  resolve(true);
                  toast.dismiss(t.id);
                }}
              >
                Oui
              </button>
              <button
                className="bg-gray-300 px-2 py-1 rounded"
                onClick={() => {
                  resolve(false);
                  toast.dismiss(t.id);
                }}
              >
                Non
              </button>
            </div>
          </div>
        ),
        { duration: Infinity }
      );
    });

    if (!confirmDelete) return;

    try {
      await rolesApi.remove(id);
      setRoles((prev) => prev.filter((r) => r.id !== id));
      toast.success("Role supprimer avec succés!");
    } catch (err) {
      console.error(err);
      toast.error("Echec de la suppression du role");
    }
  };

  const handleLogout = () => {
    authApi.logout();
    router.push("/");
  };

  if (loading)
    return (
      <div className="flex justify-center items-center mt-20">
        <ClipLoader size={60} color="#2563eb" /> {/* loader bleu */}
      </div>
    );

  if (error) return <div className="text-red-600">{error}</div>;

  return (
    <div className="p-8">
      <div className="flex justify-between items-center mb-4">
        <h2 className="text-xl font-semibold">Gestion des Roles</h2>
        <div className="flex gap-2">
          <Link
            href="/roles/new"
            className="px-3 py-2 bg-green-600 text-white rounded"
          >
            Nouveau Role
          </Link>
          <button
            onClick={handleLogout}
            className="px-3 py-2 bg-red-600 text-white rounded"
          >
            Se déconnecter
          </button>
        </div>
      </div>

      <table className="w-full table-auto border-collapse">
        <thead>
          <tr>
            <th>ID</th>
            <th>Role</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {roles.map((r) => (
            <tr key={r.id} className="border-t">
              <td className="py-2 text-center">{r.id}</td>
              <td className="py-2 text-center">{r.name}</td>
              <td className="py-2 ">{r.description}</td>
              <td className="py-2">
                <Link href={`/roles/${r.id}`} className="mr-2 underline">
                  Editer
                </Link>
                <button
                  onClick={() => handleDelete(r.id)}
                  className="text-red-600 underline"
                >
                  Supprimer
                </button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
