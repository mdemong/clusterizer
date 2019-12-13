import numpy as np


fileText = '"'		# User file
dimension = 0		# Dimension type of values inputted
clusterNum = 0;		# Amount of Clusters				
clusters = []		# Clusters used in the current model
centroids = []		# Centroids used in the current model, will be placed at random locations

data_cluster {}		# Python dictionary - Key is index accessing a list that holds data points as lists at each index
data_points = [];	# List containing all the data points
point = [];			# List representing one data point

# This is the first function used as it initializes the global variables used in other methods
# This function takes input from the PHP webpage and converts it to a HashMap consisting of 
# Key = index  of data point as Array[dimension] and Value = Centroid Value
def km_input(fileText, dimension, clusterAmount):
	clusterNum = clusterAmount



# This function computes the distance between each data point and every centroid
# Eucilidian?
def km_distance():

# Generate centroids for the amount of clusters defined by the user
def createClusters