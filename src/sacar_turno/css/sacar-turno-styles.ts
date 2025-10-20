import { StyleSheet, Dimensions } from "react-native"

const { width } = Dimensions.get("window")

export const turnoStyles = StyleSheet.create({
  // Contenedores principales
  screenContainer: {
    flex: 1,
    backgroundColor: "#F8FAFC",
  },
  contentContainer: {
    flex: 1,
    padding: 24,
    justifyContent: "center",
  },

  // Header con progreso
  headerContainer: {
    backgroundColor: "#FFFFFF",
    paddingVertical: 20,
    paddingHorizontal: 24,
    borderBottomWidth: 1,
    borderBottomColor: "#E2E8F0",
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.05,
    shadowRadius: 4,
    elevation: 3,
  },
  headerTitle: {
    fontSize: 24,
    fontWeight: "700",
    color: "#1E293B",
    marginBottom: 4,
  },
  headerSubtitle: {
    fontSize: 14,
    color: "#64748B",
    marginBottom: 16,
  },

  // Barra de progreso
  progressBarContainer: {
    flexDirection: "row",
    alignItems: "center",
    marginTop: 12,
  },
  progressStep: {
    flex: 1,
    height: 4,
    backgroundColor: "#E2E8F0",
    marginHorizontal: 4,
    borderRadius: 2,
  },
  progressStepActive: {
    backgroundColor: "#0EA5E9",
  },
  progressStepCompleted: {
    backgroundColor: "#10B981",
  },

  // Card principal
  card: {
    backgroundColor: "#FFFFFF",
    borderRadius: 16,
    padding: 24,
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.08,
    shadowRadius: 12,
    elevation: 5,
    marginVertical: 16,
  },

  // Títulos y textos
  cardTitle: {
    fontSize: 20,
    fontWeight: "600",
    color: "#1E293B",
    marginBottom: 8,
  },
  cardDescription: {
    fontSize: 14,
    color: "#64748B",
    marginBottom: 24,
    lineHeight: 20,
  },

  // Inputs mejorados
  inputContainer: {
    marginBottom: 20,
  },
  inputLabel: {
    fontSize: 14,
    fontWeight: "600",
    color: "#334155",
    marginBottom: 8,
  },
  input: {
    backgroundColor: "#F8FAFC",
    borderWidth: 2,
    borderColor: "#E2E8F0",
    borderRadius: 12,
    paddingHorizontal: 16,
    paddingVertical: 14,
    fontSize: 16,
    color: "#1E293B",
  },
  inputFocused: {
    borderColor: "#0EA5E9",
    backgroundColor: "#FFFFFF",
  },
  inputError: {
    borderColor: "#EF4444",
  },

  // Picker mejorado
  pickerContainer: {
    backgroundColor: "#F8FAFC",
    borderWidth: 2,
    borderColor: "#E2E8F0",
    borderRadius: 12,
    overflow: "hidden",
    marginBottom: 20,
  },
  picker: {
    height: 50,
  },

  // Botones principales
  primaryButton: {
    backgroundColor: "#0EA5E9",
    borderRadius: 12,
    paddingVertical: 16,
    paddingHorizontal: 24,
    alignItems: "center",
    justifyContent: "center",
    shadowColor: "#0EA5E9",
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.3,
    shadowRadius: 8,
    elevation: 4,
    marginTop: 8,
  },
  primaryButtonText: {
    color: "#FFFFFF",
    fontSize: 16,
    fontWeight: "700",
    letterSpacing: 0.5,
  },
  primaryButtonDisabled: {
    backgroundColor: "#CBD5E1",
    shadowOpacity: 0,
  },

  // Botón secundario
  secondaryButton: {
    backgroundColor: "#FFFFFF",
    borderWidth: 2,
    borderColor: "#E2E8F0",
    borderRadius: 12,
    paddingVertical: 14,
    paddingHorizontal: 24,
    alignItems: "center",
    justifyContent: "center",
    marginTop: 12,
  },
  secondaryButtonText: {
    color: "#64748B",
    fontSize: 16,
    fontWeight: "600",
  },

  // Botón de volver
  backButton: {
    flexDirection: "row",
    alignItems: "center",
    paddingVertical: 8,
    paddingHorizontal: 12,
    marginBottom: 16,
  },
  backButtonText: {
    color: "#64748B",
    fontSize: 16,
    fontWeight: "600",
    marginLeft: 8,
  },

  // Mensajes de error
  errorContainer: {
    backgroundColor: "#FEE2E2",
    borderLeftWidth: 4,
    borderLeftColor: "#EF4444",
    borderRadius: 8,
    padding: 12,
    marginBottom: 16,
  },
  errorText: {
    color: "#991B1B",
    fontSize: 14,
    fontWeight: "500",
  },

  // Mensajes de éxito
  successContainer: {
    backgroundColor: "#D1FAE5",
    borderLeftWidth: 4,
    borderLeftColor: "#10B981",
    borderRadius: 8,
    padding: 12,
    marginBottom: 16,
  },
  successText: {
    color: "#065F46",
    fontSize: 14,
    fontWeight: "500",
  },

  // Info cards
  infoCard: {
    backgroundColor: "#EFF6FF",
    borderRadius: 12,
    padding: 16,
    marginBottom: 16,
    borderLeftWidth: 4,
    borderLeftColor: "#0EA5E9",
  },
  infoLabel: {
    fontSize: 12,
    fontWeight: "600",
    color: "#0369A1",
    textTransform: "uppercase",
    letterSpacing: 0.5,
    marginBottom: 4,
  },
  infoValue: {
    fontSize: 16,
    fontWeight: "600",
    color: "#0C4A6E",
  },

  // Confirmación
  confirmationContainer: {
    alignItems: "center",
    paddingVertical: 32,
  },
  confirmationIcon: {
    width: 80,
    height: 80,
    borderRadius: 40,
    backgroundColor: "#D1FAE5",
    alignItems: "center",
    justifyContent: "center",
    marginBottom: 24,
  },
  confirmationTitle: {
    fontSize: 28,
    fontWeight: "700",
    color: "#1E293B",
    marginBottom: 12,
    textAlign: "center",
  },
  confirmationMessage: {
    fontSize: 16,
    color: "#64748B",
    textAlign: "center",
    marginBottom: 32,
    lineHeight: 24,
  },

  // Detalles del turno
  turnoDetailsContainer: {
    width: "100%",
    marginBottom: 24,
  },
  turnoDetailRow: {
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    paddingVertical: 16,
    borderBottomWidth: 1,
    borderBottomColor: "#E2E8F0",
  },
  turnoDetailLabel: {
    fontSize: 14,
    color: "#64748B",
    fontWeight: "500",
  },
  turnoDetailValue: {
    fontSize: 16,
    color: "#1E293B",
    fontWeight: "600",
  },

  // Horarios disponibles
  horariosGrid: {
    flexDirection: "row",
    flexWrap: "wrap",
    marginHorizontal: -6,
    marginBottom: 16,
  },
  horarioChip: {
    backgroundColor: "#F8FAFC",
    borderWidth: 2,
    borderColor: "#E2E8F0",
    borderRadius: 8,
    paddingVertical: 10,
    paddingHorizontal: 16,
    margin: 6,
    minWidth: 80,
    alignItems: "center",
  },
  horarioChipSelected: {
    backgroundColor: "#EFF6FF",
    borderColor: "#0EA5E9",
  },
  horarioChipText: {
    fontSize: 14,
    fontWeight: "600",
    color: "#64748B",
  },
  horarioChipTextSelected: {
    color: "#0EA5E9",
  },

  // Loading
  loadingContainer: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
    backgroundColor: "#F8FAFC",
  },
  loadingText: {
    marginTop: 16,
    fontSize: 16,
    color: "#64748B",
    fontWeight: "500",
  },

  // Navegación inferior
  bottomNavigation: {
    flexDirection: "row",
    padding: 20,
    backgroundColor: "#FFFFFF",
    borderTopWidth: 1,
    borderTopColor: "#E2E8F0",
    shadowColor: "#000",
    shadowOffset: { width: 0, height: -2 },
    shadowOpacity: 0.05,
    shadowRadius: 4,
    elevation: 5,
  },
  bottomButtonContainer: {
    flex: 1,
    marginHorizontal: 6,
  },
})
