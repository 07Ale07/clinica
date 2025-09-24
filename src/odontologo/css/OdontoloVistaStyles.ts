import { StyleSheet } from 'react-native';

export const styles = StyleSheet.create({
  safeAreaContainer: {
    flex: 1,
    backgroundColor: '#E6F0FA', // Light blue background for dental theme
  },
  container: {
    flex: 1,
  },
  content: {
    flex: 1,
    paddingHorizontal: 20,
    paddingTop: 20,
    paddingBottom: 100, // Extra padding to avoid overlap with menu
  },
  title: {
    fontSize: 32,
    fontWeight: '700',
    color: '#1B2C40', // Dark blue for text
    textAlign: 'left',
    marginBottom: 10,
    textShadowColor: 'rgba(0, 0, 0, 0.1)',
    textShadowOffset: { width: 1, height: 1 },
    textShadowRadius: 3,
  },
  subtitle: {
    fontSize: 18,
    color: '#6A7A8A', // Gray for subtitle
    marginBottom: 20,
    fontStyle: 'italic',
  },
  appointmentCard: {
    backgroundColor: '#FFFFFF',
    borderRadius: 15,
    padding: 20,
    marginBottom: 15,
    shadowColor: '#8A8F9E', // Gray shadow
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.2,
    shadowRadius: 8,
    elevation: 5,
    borderLeftWidth: 4,
    borderLeftColor: '#4B9CDB', // Blue accent
    transform: [{ translateY: 0 }], // For animation
  },
  cardContent: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
  },
  cardTextContainer: {
    flex: 1,
  },
  appointmentText: {
    fontSize: 18,
    fontWeight: '600',
    color: '#1B2C40',
    marginBottom: 5,
  },
  appointmentDetail: {
    fontSize: 16,
    color: '#6A7A8A',
    marginTop: 5,
  },
  detailButton: {
    padding: 10,
    justifyContent: 'center',
    alignItems: 'center',
  },
  errorText: {
    color: '#D9534F', // Red for errors
    textAlign: 'center',
    fontSize: 16,
    marginTop: 20,
    fontWeight: '500',
  },
  noAppointmentsText: {
    textAlign: 'center',
    fontSize: 16,
    color: '#6A7A8A',
    marginTop: 20,
    fontStyle: 'italic',
  },
  floatingButton: {
    position: 'absolute',
    bottom: 100, // Adjusted to avoid overlap with menu
    right: 20,
    backgroundColor: '#4B9CDB', // Blue button
    width: 70,
    height: 70,
    borderRadius: 35,
    justifyContent: 'center',
    alignItems: 'center',
    shadowColor: '#8A8F9E',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.3,
    shadowRadius: 8,
    elevation: 8,
    transform: [{ scale: 1 }], // For animation
  },
});