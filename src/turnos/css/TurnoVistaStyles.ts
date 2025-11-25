import { StyleSheet } from "react-native"

export const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
  },
  container: {
    flex: 1,
  },
  scrollContainer: {
    flexGrow: 1,
    justifyContent: "center",
    paddingHorizontal: 20,
    paddingBottom: 20,
  },
  headerContainer: {
    alignItems: "center",
    marginBottom: 40,
  },
  title: {
    fontSize: 36,
    fontWeight: "bold",
    color: "#FFFFFF",
  },
  formContainer: {
    backgroundColor: "#FFFFFF",
    borderRadius: 15,
    padding: 20,
    shadowColor: "#8A8F9E",
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.3,
    shadowRadius: 8,
    elevation: 5,
  },
  inputContainer: {
    flexDirection: "row",
    alignItems: "center",
    backgroundColor: "#F7FAFD",
    borderRadius: 10,
    marginBottom: 15,
    paddingHorizontal: 10,
    borderWidth: 1,
    borderColor: "#D1E6F9",
  },
  icon: {
    marginRight: 10,
  },
  input: {
    flex: 1,
    height: 50,
    fontSize: 16,
    color: "#333",
  },
  button: {
    borderRadius: 10,
    overflow: "hidden",
    marginTop: 20,
  },
  buttonGradient: {
    paddingVertical: 15,
    alignItems: "center",
  },
  buttonText: {
    color: "#FFFFFF",
    fontSize: 18,
    fontWeight: "600",
  },
  errorText: {
    color: "red",
    textAlign: "center",
    marginTop: 10,
  },
  turnoContainer: {
    marginTop: 20,
    padding: 15,
    backgroundColor: "#F7FAFD",
    borderRadius: 10,
    borderWidth: 1,
    borderColor: "#D1E6F9",
  },
  turnoCardContainer: {
    marginTop: 15,
    backgroundColor: "#FFFFFF",
    borderRadius: 12,
    borderWidth: 1.5,
    borderColor: "#D1E6F9",
    shadowColor: "#8A8F9E",
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.2,
    shadowRadius: 6,
    elevation: 3,
    overflow: "hidden",
  },
  turnoHeaderDecoration: {
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    paddingHorizontal: 15,
    paddingVertical: 12,
    backgroundColor: "#F7FAFD",
  },
  turnoHeaderLeft: {
    flex: 1,
  },
  turnoHeaderRight: {
    marginLeft: 10,
  },
  statusBadge: {
    flexDirection: "row",
    alignItems: "center",
    backgroundColor: "#4B9CDB",
    paddingHorizontal: 10,
    paddingVertical: 6,
    borderRadius: 20,
    gap: 6,
  },
  statusCompleted: {
    backgroundColor: "#008000",
  },
  statusPastTime: {
    backgroundColor: "#FF8C00",
  },
  statusExpired: {
    backgroundColor: "#FF4444",
  },
  statusPending: {
    backgroundColor: "#4B9CDB",
  },
  statusBadgeText: {
    color: "#FFFFFF",
    fontSize: 12,
    fontWeight: "600",
  },
  dividerLine: {
    height: 1,
    backgroundColor: "#D1E6F9",
  },
  miniDivider: {
    height: 1,
    backgroundColor: "#E6F0FA",
    marginVertical: 10,
  },
  turnoInfoSection: {
    paddingHorizontal: 15,
    paddingVertical: 15,
  },
  infoRow: {
    flexDirection: "row",
    alignItems: "flex-start",
    gap: 10,
  },
  infoIcon: {
    marginTop: 2,
  },
  infoContent: {
    flex: 1,
  },
  infoLabel: {
    fontSize: 12,
    color: "#8A8F9E",
    fontWeight: "600",
    marginBottom: 2,
  },
  infoValue: {
    fontSize: 15,
    color: "#333",
    fontWeight: "500",
  },
  statusMessageContainer: {
    paddingHorizontal: 15,
    paddingBottom: 12,
    gap: 8,
  },
  statusMessage: {
    flexDirection: "row",
    alignItems: "center",
    gap: 8,
    paddingHorizontal: 12,
    paddingVertical: 8,
    backgroundColor: "#F7FAFD",
    borderRadius: 8,
    borderWidth: 1,
    borderColor: "#D1E6F9",
  },
  actionButtonsContainer: {
    borderTopWidth: 1,
    borderTopColor: "#D1E6F9",
  },
  buttonDivider: {
    height: 1,
    backgroundColor: "#D1E6F9",
  },
  recordatorioButton: {
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "center",
    paddingVertical: 12,
    paddingHorizontal: 15,
    gap: 8,
  },
  recordatorioText: {
    color: "#4B9CDB",
    fontSize: 15,
    fontWeight: "600",
  },
  cancelButton: {
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "center",
    paddingVertical: 12,
    paddingHorizontal: 15,
    gap: 8,
  },
  cancelText: {
    color: "#FF4444",
    fontSize: 15,
    fontWeight: "600",
  },
  expiredText: {
    color: "#FF4444",
    fontSize: 16,
    fontWeight: "600",
    marginTop: 5,
  },
  completedText: {
    color: "#008000",
    fontSize: 16,
    fontWeight: "600",
    marginTop: 5,
  },
  pastTimeText: {
    color: "#FF8C00",
    fontSize: 16,
    fontWeight: "600",
    marginTop: 5,
  },
})
