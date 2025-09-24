import { StyleSheet } from 'react-native';

export const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#E6F0FA', // Light blue background matching OdontoloVistaStyles
    paddingHorizontal: 20,
    paddingTop: 20,
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
  dayPicker: {
    backgroundColor: '#FFFFFF',
    borderRadius: 15,
    marginBottom: 20,
    padding: 10,
    shadowColor: '#8A8F9E', // Gray shadow
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.2,
    shadowRadius: 8,
    elevation: 5,
    borderLeftWidth: 4,
    borderLeftColor: '#4B9CDB', // Blue accent
  },
  list: {
    paddingBottom: 20,
  },
  scheduleItem: {
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
  },
  scheduleText: {
    fontSize: 18,
    fontWeight: '600',
    color: '#1B2C40', // Dark blue
    marginBottom: 5,
  },
  scheduleSubText: {
    fontSize: 16,
    color: '#6A7A8A', // Gray
    marginVertical: 5,
  },
  editButton: {
    backgroundColor: '#4B9CDB', // Blue button
    borderRadius: 10,
    padding: 10,
    alignSelf: 'flex-end',
    justifyContent: 'center',
    alignItems: 'center',
  },
  editButtonText: {
    color: '#FFFFFF',
    fontSize: 14,
    fontWeight: '600',
  },
  addButton: {
    backgroundColor: '#4B9CDB', // Blue button
    borderRadius: 15,
    padding: 15,
    alignItems: 'center',
    marginTop: 10,
    shadowColor: '#8A8F9E',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.3,
    shadowRadius: 8,
    elevation: 8,
  },
  addButtonText: {
    color: '#FFFFFF',
    fontSize: 16,
    fontWeight: '700',
  },
  loadingText: {
    textAlign: 'center',
    fontSize: 16,
    color: '#6A7A8A', // Gray
    marginTop: 20,
    fontStyle: 'italic',
  },
  errorText: {
    textAlign: 'center',
    fontSize: 16,
    color: '#D9534F', // Red for errors
    marginTop: 20,
    fontWeight: '500',
  },
  noSchedulesText: {
    textAlign: 'center',
    fontSize: 16,
    color: '#6A7A8A', // Gray
    marginTop: 20,
    fontStyle: 'italic',
  },
});