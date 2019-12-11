from scipy.stats import norm
import numpy as np
# NOTE: To run this code, you may need to run: 
#       `pip install scipy`
#       `pip install numpy` 
#       if you have not already installed numpy and scipy.

# It is recommended to use numpy arrays for efficiency. See https://stackoverflow.com/a/994010


# TODO: define function signature
# This function takes input from PHP and converts it to a convenient format
def read_input():

    
    # Assuming 2 distributions (i.e. binary classification)
    DIST_COUNT = 2
    # TODO: actual data input from PHP
    temp_points = np.array(1, 2, 3);

    expectation_maximization(DIST_COUNT, temp_points)


# Performs the Expectation Maximization algorithm as described in:
# Clustering for malware classification; Pai et al. (2016)
# 
def expectation_maximization(k, temp_points, distributions=np.array()):
    # Initialize parameters (mean, variance)

    if(distributions==[]):
        distributions = init_random_distributions(k)

    # Alternate between E and M step until change is negligable
    changed = True
    while(changed):
        # TODO: modify 'changed' based on exp. and max. function outputs
        changed = False

        # E step: Compute probabilities needed in M step, based on
          # current estimates of the distribution parameters
        expectation()

        # M Step: Use the probabilities from the E step to recompute
          # the distribution parameters, based on 
          # maximum likelihood estimators
        maximization()
    return []


def init_random_distributions(count):
    # For now, assuming we can have any float as a mean or SD
    MIN_RANDOM_MEAN = np.finfo.min
    MAX_RANDOM_MEAN = np.finfo.max
    
    MIN_RANDOM_SD = np.finfo.min
    MAX_RANDOM_SD = np.finfo.max

    dists = np.array()
    for i in range(count):
        mean = np.random.uniform(low=MIN_RANDOM_MEAN, high=MAX_RANDOM_MEAN)
        sd = np.random.uniform(low=MIN_RANDOM_SD, high=MAX_RANDOM_SD)
        new_dist = norm(mean, sd)
        dists = np.append(dists, new_dist)
    return dists


# TODO: define function signature
def expectation():
    return


# TODO: define function signature
def maximization():
    return