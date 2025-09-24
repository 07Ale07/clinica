import { getInventario, InventoryItem } from '../modelo/inventario_modelo';

export const InventarioControl = {
  async fetchInventario(): Promise<InventoryItem[]> {
    try {
      return await getInventario();
    } catch (error) {
      throw new Error('Error al cargar el inventario. Intente nuevamente.');
    }
  }
};